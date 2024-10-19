<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStackRequest;
use App\Models\Item;
use App\Models\ItemStack;
use App\Services\CategoryService;
use App\Services\ItemStackService;
use App\Services\QR\QRImageWithLogo;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Common\Version;
use chillerlan\QRCode\Data\QRCodeDataException;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QRCodeOutputException;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class ItemStackController extends Controller
{
    public function index(CategoryService $categoryService)
    {
        $this->authorize('viewAny', ItemStack::class);

        return view('item-stacks.index', [
            'itemStacks' => ItemStack::all(), 'categories' => $categoryService->selectArray()
        ]);
    }

    public function show(ItemStack $itemStack)
    {
        $this->authorize('view', $itemStack);

        if (request()->expectsJson()) {
            return response()->json([
                'data' => $itemStack
            ]);
        }
    }

    public function store(ItemStackRequest $request, ItemStackService $itemStackService)
    {
        $this->authorize('create', ItemStack::class);
        $data = $request->validated();
        if ($request->has('is_set')) {
            $data['is_set'] = true;
        }

        $itemStack = ItemStack::create($data);
        $itemStack->items()->create([
            'name' => $itemStack->name,
            'is_intact' => true
        ]);

        // check for uploaded image
        if (($image = $request->file('image')) !== null && $image->isValid()) {
            $itemStackService->saveUploadedImage($image, $itemStack);
        }

        return redirect(route('itemStacks.index'));
    }

    public function edit(ItemStack $itemStack, CategoryService $categoryService)
    {
        $this->authorize('update', $itemStack);

        return view('item-stacks.edit', [
            'itemStack' => $itemStack, 'categories'  => $categoryService->selectArray()
        ]);
    }

    public function update(ItemStackRequest $request, ItemStack $itemStack, ItemStackService $itemStackService)
    {
        $this->authorize('update', $itemStack);
        $data = $request->validated();

        // check for uploaded image
        if (($image = $request->file('image')) !== null && $image->isValid()) {
            $itemStackService->saveUploadedImage($image, $itemStack);
        }

        $itemStack->update($data);

        return back();
    }

    public function destroy(ItemStack $itemStack)
    {
        $this->authorize('delete', $itemStack);

        $itemStack->delete();

        return back();
    }

    public function generateQrCode(ItemStack $itemStack, Item $item)
    {
        $this->authorize('update', $itemStack);

        $options = new QROptions;

        $options->version             = Version::AUTO;
        $options->outputBase64        = false;
        $options->scale               = 24;
        $options->imageTransparent    = false;
        $options->drawCircularModules = false;
        $options->circleRadius        = 0.45;
        $options->keepAsSquare        = [
            QRMatrix::M_FINDER,
            QRMatrix::M_FINDER_DOT,
        ];

        #84b816
        /*$options->moduleValues = [
            // finder
            QRMatrix::M_FINDER_DARK => [132, 184, 22],    // dark (true)
            QRMatrix::M_FINDER_DOT => [132, 184, 22],    // finder dot, dark (true)
            QRMatrix::M_FINDER => [255, 255, 255], // light (false)
        ];*/

        // ecc level H is required for logo space
        $options->eccLevel            = EccLevel::H;
        $options->addLogoSpace        = true;
        $options->logoSpaceWidth      = 13;
        $options->logoSpaceHeight     = 5;

        $qrcode = new QRCode($options);
        $qrcode->addByteSegment(
            config('qr.url') . route('items.scan', ['item' => $item], false)
        );

        try {
            $qrOutputInterface = new QRImageWithLogo($options, $qrcode->getQRMatrix());
        } catch (QRCodeDataException|QRCodeOutputException $e) {
            return back()->withErrors([$e->getMessage()]);
        }

        $subtitle = config('qr.subtitle.show') ? "{$itemStack->name} ($item->name)" : null;
        $logo = config('qr.logo.show') ? config('qr.logo.path') : null;

        $out = $qrOutputInterface->dump(null, $logo, $subtitle);
        return response()->make($out, 200)->header('Content-Type', 'image/png')
            ->header('Content-Disposition', "attachment; filename=item-{$item->id}.png");
    }
}

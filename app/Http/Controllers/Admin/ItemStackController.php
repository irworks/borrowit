<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStackRequest;
use App\Models\Item;
use App\Models\ItemStack;
use App\Services\CategoryService;
use App\Services\QR\QRImageWithLogo;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
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

    public function store(ItemStackRequest $request)
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

        return redirect(route('itemStacks.index'));
    }

    public function edit(ItemStack $itemStack, CategoryService $categoryService)
    {
        $this->authorize('update', $itemStack);

        return view('item-stacks.edit', [
            'itemStack' => $itemStack, 'categories'  => $categoryService->selectArray()
        ]);
    }

    public function update(ItemStackRequest $request, ItemStack $itemStack)
    {
        $this->authorize('update', $itemStack);
        $data = $request->validated();

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
        $options = new QROptions;

        $options->version             = 5;
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
        $options->logoSpaceHeight     = 5.5;

        $qrcode = new QRCode($options);
        $qrcode->addByteSegment(route('items.scan', ['item' => $item]));

        $qrOutputInterface = new QRImageWithLogo($options, $qrcode->getQRMatrix());

        // dump the output, with an additional logo
        // the logo could also be supplied via the options, see the svgWithLogo example
        $out = $qrOutputInterface->dump(null, resource_path('img/asta-logo.PNG'), "{$itemStack->name} ($item->name)");
        return response()->make($out, 200)->header('Content-Type', 'image/png')
            ->header('Content-Disposition', "attachment; filename=item-{$item->id}.png");
    }
}

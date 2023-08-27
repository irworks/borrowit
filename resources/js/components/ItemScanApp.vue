<template>
  <div>
    <div v-if="currentView === 'main'" class="my-3 text-center">
      <button class="btn btn-primary" @click="openScanner">
        <i class="bi bi-qr-code-scan"></i> {{ openScannerLabel }}
      </button>
    </div>

    <scanner v-if="currentView === 'scanner'"
             @result="onScanComplete">
    </scanner>

    <b class="fs-5">{{ listItemStacksLabel }}</b>
    <item-stack-list :item-stacks="itemStacks"
                     :scanned-item-stacks="scannedItemStacks"
                     :count-placeholders="countPlaceholders"
                     :loading="loading"
                     :pieces="piecesLabel"
                     :scanned="scannedLabel">
    </item-stack-list>

    <slot></slot>

    <div class="mt-3 d-flex justify-content-end">
      <button @click="submit" class="btn" :class="isEverythingScanned ? 'btn-primary' : 'btn-warning'" :disabled="!isBookingValid">
        {{ submitLabel }} <i class="ms-1 bi bi-calendar2-check"></i>
      </button>
    </div>
  </div>
</template>

<script>
import Scanner from './Scanner.vue';
import ItemStackList from './ItemStackList.vue';

const beepAudio = new Audio('/audio/beep.mp3');

export default {
  name: "ItemScanApp",
  emits: ['submit'],
  components: {
    Scanner,
    ItemStackList
  },
  props: {
    itemStacks: {
      required: true
    },
    countPlaceholders: {
      default: 0
    },
    loading: {
      required: true
    },
    piecesLabel: {
      default: 'pieces'
    },
    scannedLabel: {
      default: 'scanned'
    },
    submitLabel: {
      default: 'submit'
    },
    openScannerLabel: {
      default: 'open scanner'
    },
    listItemStacksLabel: {
      default: 'list item stacks'
    }
  },
  data() {
    return {
      currentView: 'main',
      scannedItemStacks: {},
      scannedItemIds: []
    }
  },
  methods: {
    openScanner() {
      this.currentView = 'scanner';
    },
    onScanComplete(itemId) {
      if (this.scannedItemIds.includes(itemId)) {
        return;
      }

      beepAudio.play();
      this.scannedItemIds.push(itemId);
      this.loadItem(itemId).then(result => {
        let item = result.data.data;
        if (!this.scannedItemStacks.hasOwnProperty(item.item_stack_id)) {
          this.scannedItemStacks[item.item_stack_id] = [];
        }

        this.scannedItemStacks[item.item_stack_id].push(item);
      });
    },
    loadItem(itemId) {
      return axios.get(`/items/${itemId}`);
    },
    submit() {
      this.$emit('submit', this.scannedItemIds);
    }
  },
  computed: {
    isBookingValid() {
      return Object.keys(this.scannedItemStacks).length > 0;
    },
    isEverythingScanned() {
      let result = true;

      this.itemStacks.forEach(itemStack => {
        if ((this.scannedItemStacks[itemStack.meta.id]?.length ?? 0) < itemStack.quantity) {
          result = false;
          return false;
        }
      });

      return result;
    }
  },
}
</script>

<style scoped>

</style>
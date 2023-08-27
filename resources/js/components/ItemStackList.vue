<script>
export default {
  name: "ItemStackList",
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
    pieces: {
      default: 'pieces'
    },
    scanned: {
      default: 'scanned'
    },
    list: {
      default: 'list'
    },
    scannedItemStacks: {
      required: true
    }
  },
  data() {
    return {
    }
  },
  methods: {
    listOfScannedItems(itemStackId) {
      if (!this.scannedItemStacks.hasOwnProperty(itemStackId)) {
        return [];
      }

      return this.scannedItemStacks[itemStackId].map(itemStack => itemStack.name).join(', ');
    },
  }
}
</script>

<template>
  <div>
    <ul class="placeholder-glow list-group">
      <template v-if="loading">
        <li class="list-group-item" v-for="n in countPlaceholders">
          <span class="placeholder col-12"></span>
        </li>
      </template>

      <div v-else>
        <li v-for="item in itemStacks"
            class="list-group-item d-flex justify-content-between align-items-center"
            :class="{ 'bg-success text-light': scannedItemStacks[item.meta.id]?.length === item.quantity }">
          <div>
            {{ item.meta.name }}

            <div v-if="item.items?.length > 0">
              <small>
                <b>{{ list }}:</b> {{ item.items.map(itemObj => itemObj.name).join(', ') }}
              </small>
            </div>

            <div v-if="listOfScannedItems(item.meta.id)?.length > 0">
              <small>
                <b>{{ scanned }}:</b> {{ listOfScannedItems(item.meta.id) }}
              </small>
            </div>
          </div>

          <span class="badge bg-primary rounded-pill">{{ scannedItemStacks[item.meta.id]?.length ?? 0 }} / {{ item.quantity }} {{pieces }}</span>
        </li>
      </div>
    </ul>
  </div>
</template>

<style scoped>

</style>
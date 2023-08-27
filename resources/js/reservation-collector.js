import {createApp} from 'vue/dist/vue.esm-bundler';
import Scanner from './components/Scanner.vue';
import ItemStackList from './components/ItemStackList.vue';

const beepAudio = new Audio('/audio/beep.mp3');
const app = createApp({
    components: {
        Scanner,
        ItemStackList
    },
    data() {
        return {
            currentView: 'main',
            loading: false,
            complete: false,
            reservationId: -1,
            itemStacks: [],
            scannedItemStacks: {},
            scannedItemIds: []
        }
    },
    watch: {

    },
    methods: {
        loadItems() {
            this.loading = true;
            this.reservationId = window.RESERVATION_ID;

            axios.get(`/reservations/${this.reservationId}/collect/details`).then(result => {
                this.itemStacks = result.data.data.item_stacks;
                this.loading = false;
            });
        },
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
            axios.post(`/reservations/${this.reservationId}/book`, {
                itemIds: this.scannedItemIds
            });
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
    created() {
        this.loadItems();
    }
});

app.mount("#reservation-collector-app");

import {createApp} from 'vue/dist/vue.esm-bundler';
import ItemScanApp from './components/ItemScanApp.vue';

const app = createApp({
    components: {
        ItemScanApp
    },
    data() {
        return {
            loading: false,
            reservationId: -1,
            itemStacks: [],
        }
    },
    watch: {},
    methods: {
        loadItems() {
            this.loading = true;
            this.reservationId = window.RESERVATION_ID;

            axios.get(`/reservations/${this.reservationId}/collect/details`).then(result => {
                this.itemStacks = result.data.data.item_stacks;
                this.loading = false;
            });
        },
        submit(scannedItemIds) {
            axios.post(`/reservations/${this.reservationId}/collect`, {
                itemIds: scannedItemIds
            }).then(result => {
                // TODO: Redirect away? Show message?
            });
        }
    },
    created() {
        this.loadItems();
    }
});

app.mount("#reservation-collector-app");
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
            error: false,
            errorMessage: '',
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
                let success = result.data.success;
                if (success) {
                    window.location = '/';
                    return;
                }

                this.errorMessage = 'Failed to create a booking based on the current reservation.';
                this.error = true;
            });
        }
    },
    created() {
        this.loadItems();
    }
});

app.mount("#reservation-collector-app");

import {createApp} from 'vue/dist/vue.esm-bundler';
import ItemScanApp from './components/ItemScanApp.vue';

const app = createApp({
    components: {
        ItemScanApp
    },
    data() {
        return {
            loading: false,
            error: false,
            bookingId: -1,
            items: [],
            itemStacks: [],
            loadedItemStacks: {}
        }
    },
    watch: {},
    methods: {
        loadItems() {
            this.loading = true;
            this.bookingId = window.BOOKING_ID;

            axios.get(`/bookings/${this.bookingId}/return/details`).then(result => {
                this.items = result.data.data.items;
                this.loadItemStacks();
            });
        },
        loadItemStacks() {
            let toLoad = [];
            this.items.forEach(item => {
                if (!this.loadedItemStacks.hasOwnProperty(item.item_stack_id)) {
                    this.loadedItemStacks[item.item_stack_id] = {
                        quantity: 1,
                        items: [{
                            id: item.item_id,
                            name: item.name,
                        }]
                    };

                    toLoad.push(item.item_stack_id);
                } else {
                    this.loadedItemStacks[item.item_stack_id]['quantity'] += 1;
                    this.loadedItemStacks[item.item_stack_id]['items'].push({
                        id: item.item_id,
                        name: item.name,
                    });
                }
            });

            toLoad.forEach(itemStackId => this.loadItemStack(itemStackId));
        },
        loadItemStack(itemStackId) {
            axios.get(`/itemStacks/${itemStackId}`).then(result => {
                console.log(result.data);
                this.itemStacks.push({
                    quantity: this.loadedItemStacks[itemStackId].quantity,
                    meta: result.data.data,
                    items: this.loadedItemStacks[itemStackId].items
                });

                this.loading = false;
            });
        },
        submit(scannedItemIds) {
            this.error = false;

            axios.post(`/bookings/${this.bookingId}/return`, {
                itemIds: scannedItemIds
            }).then(response => {
                const result = response.data.result;
                if (result) {
                    window.location = '/';
                } else {
                    this.error = true;
                }
            });
        }
    },
    created() {
        this.loadItems();
    }
});

app.mount("#booking-return-app");

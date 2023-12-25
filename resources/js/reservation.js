import {createApp} from 'vue/dist/vue.esm-bundler';

const app = createApp({
    components: {
    },
    data() {
        return {
            loading: false,
            from: null,
            to: null,
            valid: false,
            items: [],
            error: false,
            errorMessage: '',
        }
    },
    watch: {

    },
    methods: {
        loadItems() {
            this.loading = true;

            axios.get(`/reservation/itemStacks/availability`).then(result => {
                this.items = result.data.data.items;
                this.valid = result.data.data.available;

                this.from = result.data.reservation.from;
                this.to = result.data.reservation.to;

                this.loading = false;
            });
        },
        updateTimes() {
            this.loading = true;
            this.error = false;
            this.errorMessage = '';

            axios.patch(`/reservation/interval`, {
                from: this.from,
                to: this.to,
            }).catch(error => {
                this.error = true;
                this.errorMessage = error.response.data.message;
            }).then(result => {
                this.loadItems();
            })
        },
        increaseQuantity(itemMeta) {
            axios.patch(`/reservation/itemStacks/${itemMeta.reservation_item_stack_id}`, {
                quantity: itemMeta.quantity + 1
            }).then(result => {
                this.loadItems();
            }).catch(error => {

            });
        },
        decreaseQuantity(itemMeta) {
            axios.patch(`/reservation/itemStacks/${itemMeta.reservation_item_stack_id}`, {
                quantity: itemMeta.quantity - 1
            }).then(result => {
                this.loadItems();
            }).catch(error => {

            });
        }
    },
    computed: {
        currentSlots() {
        },
    },
    created() {
        this.loadItems();
    }
});

app.mount("#reservation-app");

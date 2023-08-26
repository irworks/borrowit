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
            items: []
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

            axios.patch(`/reservation/interval`, {
                from: this.from,
                to: this.to,
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

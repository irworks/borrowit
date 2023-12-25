<script>
export default {
    data() {
        return {
            quantity: 1,
            maxAmount: 1,

            lang: {
                quantityLabel: '',
                reserve: '',
            }
        }
    },
    methods: {
        increaseQuantity() {
            this.quantity++;
        },
        decreaseQuantity() {
            this.quantity = Math.max(0, --this.quantity);
        }
    },
    created() {
        this.maxAmount = ITEM_STACK_MAX_AMOUNT;
        this.lang = VUE_LANG;
    }
};
</script>

<template>
    <div>
        <div v-if="maxAmount > 1">
            <label for="quantity" id="quantity-label" class="form-label">{{ lang.quantityLabel }}</label>
            <div class="input-group mb-3">
                <button class="btn btn-outline-primary" type="button" @click.prevent="decreaseQuantity()"
                        :disabled="quantity <= 1">-
                </button>
                <input type="number" class="form-control" placeholder="1"
                       :aria-label="lang.quantityLabel" aria-describedby="quantity-label"
                       v-model="quantity"
                       name="quantity" min="1" :max="maxAmount" id="quantity">
                <button class="btn btn-outline-primary" @click.prevent="increaseQuantity()"
                        :disabled="quantity >= maxAmount">+
                </button>
            </div>

        </div>
        <input v-else type="hidden" name="quantity" value="1">

        <button type="submit" class="btn btn-primary" :disabled="maxAmount <= 0">
            <i class="me-1 bi bi-calendar-plus"></i>{{ quantity }}x {{ lang.reserve }}
        </button>
    </div>
</template>

<style scoped>

</style>

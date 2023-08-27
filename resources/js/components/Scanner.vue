<template>
  <q-r-code-scanner @content="onCodeScanned"></q-r-code-scanner>

  <div v-if="invalidCode" class="alert alert-warning position-absolute bottom-0 shadow" style="left: 10px; right: 10px;"
       role="alert">
    Dieser QR Code kein gültiger Item Code!
  </div>
</template>

<script>
import QRCodeScanner from "./QRCodeScanner.vue";

export default {
  name: "Scanner",
  emits: ['result'],
  components: {
    QRCodeScanner
  },
  data() {
    return {
      itemId: -1,
      invalidCode: false
    }
  },
  methods: {
    onCodeScanned(content) {
      let result = this.parseCode(content);
      if (!result) {
        // not a valid checkin code
        this.setInvalidCode();
        return;
      }

      this.$emit('result', this.itemId);
    },
    setInvalidCode() {
      this.invalidCode = true;
      setTimeout(() => this.invalidCode = false, 1000 * 5);
    },
    parseCode(code) {
      const baseUrl = window.location.protocol + '\/\/' + window.location.host + '\/items';
      const pattern = baseUrl + '\/([0-9]+)\/scan';

      const regex = new RegExp(pattern, 'i');
      let result = code.match(regex);
      if (result === null) {
        return false;
      }

      this.itemId = result[1];
      return true;
    }
  }
}
</script>

<style scoped>

</style>

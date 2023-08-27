<template>
    <video ref="videoObject" style="width: 100%;"></video>
</template>

<script>
import QrScanner from 'qr-scanner';

export default {
    name: "QRCodeScanner",
    emits: ['content'],
    methods: {
        onCodeScanned(result) {
            this.$emit('content', result.data);
        }
    },
    mounted() {
        this.qrScanner = new QrScanner(this.$refs.videoObject, this.onCodeScanned, {
            onDecodeError: (error) => {
                if (error === "No QR code found") return;
                console.log(error);
            },
            highlightScanRegion: true,
            highlightCodeOutline: true,
        });
        this.qrScanner.start();
    }
}
</script>

<style scoped>

</style>

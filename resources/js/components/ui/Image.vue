<template>
    <div class="bg-slate-200 w-full h-full">        
        <img v-if="!noImage" :src="src"  :class="class" alt="img" @error="loadError">      
    </div>
</template>

<script>
    export default {
        props: {
            src: String,
            class: String,
        },
        data() {
            return {
                noImage: false,
            }
        },
        methods: {
            loadError(e) {                               
                this.noImage = true;               
            }
        }       
    }
</script>

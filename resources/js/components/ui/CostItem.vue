<template>
  <div v-if="value > 0" class="xl:mb-2">
    <div
      v-if="discount"
      class="font-bold text-sm xs:text-base !leading-6 flex items-center absolute xl:static top-2 pl-4 xl:pl-0"
    >
      <div class="mr-2">
       <img src="/img/red_bolt.svg" alt="bolt"/>
      </div>
      <div class="text-red-700">{{ discount }} ₽</div>
    </div>
    <div class="text-sm xs:text-base !leading-6 font-bold">
      <span :class="discount ? 'line-through' : ''">{{ value }}</span> ₽/{{
        name
      }}
    </div>
    <div class="text-xs xs:text-sm !leading-6">
      {{ info }}
    </div>
  </div>
  <div v-if="value == 0" class="xl:mb-2">
    <div class="text-sm xs:text-base !leading-6 font-bold">
      <span>{{ name }}</span>
    </div>
    <div class="text-xs xs:text-sm !leading-6">
      {{ description }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: [Number, String],
    name: String,
    info: String,
    description: String,
    discount: [Number, String],
  },
};
</script>

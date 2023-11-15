<template>
  <div
    v-if="value > 0"
    class="border border-[#6170FF] border-solid rounded-[8px] py-[13px] px-[5px] grow sm:border-0 sm:py-[5px]"
  >
    <div
      v-if="cost_period"
      class="font-bold text-sm xs:text-base flex items-center w-full justify-center xl:static top-2 pl-4 xl:pl-0"
    >
      <div class="mr-2">
        <img src="/img/red_bolt.svg" alt="bolt"/>
      </div>
      <div class="text-red-700">{{ cost_period.value }} ₽</div>
    </div>
    <p class="text-[16px] leading-[19px] font-semibold text-center">
      <span :class="cost_period ? 'line-through' : ''">{{ cost_period ? cost_period.avg_value : value }}</span> ₽/{{
        name
      }}
    </p>
    <p class="text-[14px] leading-[16px] text-center">
      {{ info }}
    </p>
  </div>
  <div
    v-if="value == 0"
    class="border border-[#6170FF] border-solid rounded-[8px] py-[13px] px-[5px] grow sm:border-0 sm:py-[5px]"
  >
    <p class="text-[16px] leading-[19px] font-semibold text-center">
      {{ name }}
    </p>
    <p class="text-[14px] leading-[16px] text-center">
      {{ description }}
    </p>
  </div>
</template>

<script>
export default {
  props: {
    value: [Number, String],
    name: String,
    info: String,
    description: String,
    cost_period: Object,
  },
};
</script>

<template>
  <div v-if="value > 0" class="xl:mb-2">
    <div
      v-if="cost_period"
      class="font-bold text-sm xs:text-base !leading-6 flex items-center top-2 w-full"
      :class="is_room ? 'justify-center lg:justify-start' : 'justify-center'"
    >
      <div class="mr-2">
       <img src="/img/red_bolt.svg" alt="bolt"/>
      </div>
      <div class="text-red-700">{{ cost_period.value }} ₽</div>
    </div>
    <div class="text-sm xs:text-base !leading-6 font-bold">
      <span :class="cost_period ? 'line-through' : ''">{{ cost_period ? cost_period.avg_value : value }}</span> ₽/{{
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
    cost_period: Object,
    is_room: {
      type: Boolean,
      default: false
    }
  },
};
</script>

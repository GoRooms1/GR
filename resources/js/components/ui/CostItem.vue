<template>
  <div v-if="value > 0" class="xl:mb-2">
    <div
      v-if="discount"
      class="font-bold text-sm xs:text-base flex items-center absolute xl:static top-2 pl-4 xl:pl-0"
    >
      <div class="mr-2">
        <svg
          width="11"
          height="15"
          viewBox="0 0 11 15"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M7.9437 1.45801C8.05312 1.18431 7.85153 0.886597 7.55678 0.886597H2.63921C2.45986 0.886597 2.30064 1.00135 2.24393 1.1715L0.021701 7.83818C-0.0682323 8.10801 0.132584 8.3866 0.416984 8.3866H2.63857C2.90964 8.3866 3.10854 8.64135 3.04279 8.90435L1.8704 13.5938C1.76791 14.0038 2.27044 14.2883 2.56926 13.9896L9.96095 6.59793C10.2235 6.33543 10.0375 5.8866 9.66628 5.8866H6.78762C6.49287 5.8866 6.29128 5.58888 6.40078 5.31519L7.9437 1.45801Z"
            fill="#E1183D"
          ></path>
        </svg>
      </div>
      <div class="text-red-700">{{ discount }} ₽</div>
    </div>
    <div class="text-sm xs:text-base font-bold">
      <span :class="discount ? 'line-through' : ''">{{ value }}</span> ₽/{{
        name
      }}
    </div>
    <div class="text-xs xs:text-sm">
      {{ info }}
    </div>
  </div>
  <div v-if="value == 0" class="xl:mb-2">
    <div class="text-sm xs:text-base font-bold">
      <span>{{ name }}</span>
    </div>
    <div class="text-xs xs:text-sm">
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

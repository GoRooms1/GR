<template>
  <div
    class="ml-auto flex py-1 px-2 rounded-md text-white text-sm"
    :class="withChashback ? 'bg-green-500' : 'bg-gray-500'"
  >
    <div>
      <img src="/img/cashback-small2.svg" alt="cashback" width="20" height="20"/>
    </div>
    <div class="ml-1">
      {{ withChashback ? "Кешбэк" : "Без кешбэка" }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    withChashback: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<template>
  <svg
      width="20"
      height="16"
      viewBox="0 0 20 16"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M17.2341 12.231H16.3395L12.6232 3H12.6201L10.117 8.22059L7.6201 3H7.61703L3.89461 12.231H3V13H8.12561V12.231H7.10846L8.29412 9.30208L10.117 13L11.9461 9.30208L13.1256 12.231H12.1085V13H17.2341V12.231Z"
        :fill="'#' + color"
      ></path>
  </svg>
</template>

<script>
export default {
  props: {
    color: String,     
  },  
};
</script>

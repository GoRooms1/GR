<template>
  <div class="hidden lg:flex py-2">
    <a
      v-if="$page.props?.contacts?.telegram"
      :href="$page.props.contacts.telegram"
      target="_blank"
      class="mr-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/soc11.svg)] hover:bg-[url(/img/soc12.svg)]"
    >
    </a>
    <a
      v-if="$page.props?.contacts?.zen"
      :href="$page.props.contacts.zen"
      target="_blank"
      class="mr-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/soc21.svg)] hover:bg-[url(/img/soc22.svg)]"
    >
    </a>
    <a
      v-if="$page.props?.contacts?.vk"
      :href="$page.props.contacts.vk"
      target="_blank"
      class="mr-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/soc31.svg)] hover:bg-[url(/img/soc32.svg)]"
    >
    </a>
    <a
      v-if="$page.props?.contacts?.youtube"
      :href="$page.props.contacts.youtube"
      target="_blank"
      class="mr-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/soc41.svg)] hover:bg-[url(/img/soc42.svg)]"
    >
    </a>
  </div>
</template>

<script>
export default {};
</script>

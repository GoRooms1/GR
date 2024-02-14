<template>
  <div class="pt-16 pb-4 px-2">
      <div class="flex flex-wrap md:flex-nowrap">
        <Link as="button" href="/client/bookings" class="p-2 mx-2 my-2 flex w-full items-center justify-center rounded-lg hover:bg-[#6170FF] hover:text-white"
          :class="$page.props.path === '/client/bookings' ? 'bg-[#6170FF] text-white' : 'bg-white'"
        >
          Бронирования
        </Link>
        <Link as="button" href="/client/favorites" class="p-2 mx-2 my-2 flex w-full items-center justify-center rounded-lg hover:bg-[#6170FF] hover:text-white"
          :class="$page.props.path === '/client/favorites' ? 'bg-[#6170FF] text-white' : 'bg-white'"
        >
          Избранное
        </Link>
        <Link as="button" href="/client/settings" class="p-2 mx-2 my-2 flex w-full items-center justify-center rounded-lg hover:bg-[#6170FF] hover:text-white"
          :class="$page.props.path === '/client/settings' ? 'bg-[#6170FF] text-white' : 'bg-white'"
        >
          Настройки
        </Link>
      </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
  components: {
    Link,
  },  
};
</script>

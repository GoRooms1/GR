<template>
  <div v-bind="$attrs">
    © {{ new Date().getFullYear() }}
    {{ $page.props?.contacts?.org_name ?? "GoRooms" }}
  </div>
</template>

<script>
export default {};
</script>

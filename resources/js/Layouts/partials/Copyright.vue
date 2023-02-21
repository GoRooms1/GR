<template>
    <div v-bind="$attrs">
      © {{new Date().getFullYear()}} {{$page.props.contacts.org_name}}
    </div>
</template>

<script>
    export default {        
    }
</script>

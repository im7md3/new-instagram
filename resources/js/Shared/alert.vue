<template>
<div class="">
    <div v-if="$page.props.flash.success" class="px-3 py-3 bg-green-500 text-white shadow-md rounded-md">{{$page.props.flash.success}}</div>
    <div v-if="$page.props.flash.fail" class="px-3 py-3 bg-red-500 text-white shadow-md rounded-md">{{$page.props.flash.error}}</div>
</div>
</template>

<script>
export default {
    
}
</script>
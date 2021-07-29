<template>
    <div class="">
        <input v-model="search" @keyup='findProfile()' type="text" placeholder="Search"
            class="border border-gray-300 border-solid text-center p-1">
        <ul  v-if="results.length>0"
            class="absolute  w-auto bg-white p-1 shadow-lg border border-gray-500 border-solid z-10">
                <li v-for="profile in results" :key="profile.id"
                    class="flex flex-row items-center  my-1 ">
                    <inertia-link class="font-bold text-blue-500 hover:underline"
                        :href="route('user.profile',profile.username)">
                        <img :src="profile.profile_photo_url" :alt="profile.username"
                            class="rounded-full h-10 w-10 mr-24">
                    </inertia-link>
                    <span>
                        <inertia-link class="font-bold text-blue-500 hover:underline"
                            :href="route('user.profile',profile.username)">
                            {{ profile.username }}</inertia-link>
                    </span>
                </li>
                <hr class="h-2">
        </ul>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                search:"",
                results: {}
            }
        },
        methods: {
            findProfile() {
                axios.post(route('search'),{key:this.search}).then(e=>{
                    this.results=e.data
                })
            }
        }
    }

</script>

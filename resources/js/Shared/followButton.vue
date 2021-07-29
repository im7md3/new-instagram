<template>
<span v-if="$page.props.user && $page.props.user.id!=profile.id">
    <button v-if="isFollow" @click="followUser"
        class="bg-blue-500 rounded-lg shadow px-2 py-1 text-white whitespace-nowrap">{{ __('Unfollow') }}
    </button>
    <button v-else @click="followUser"
        class="bg-blue-500 rounded-lg shadow px-2 py-1 text-white whitespace-nowrap">{{ __('Follow') }}
    </button>
    </span>
</template>

<script>
    export default {
        props:{
            isFollowUser:Boolean,
            profile: Object,
        },
        data(){
            return{
                isFollow:this.isFollowUser,
                follows_count:this.profile.follows_count,
                followers_count:this.profile.followers_count,
            }
        },
        methods:{
            followUser(){
                if(this.$page.props.user){
                axios.post(route('toggle.follow'),{user_id:this.profile.id}).then(e=>{
                    this.isFollow=e.data.isFollow
                    this.followers_count=e.data.followerCount
                    if(route().current('user.profile')){
                        this.$emit('changeFollowers',this.followers_count);
                    }
                });
                }
            }
        },

    }
</script>

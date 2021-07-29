<template>
    <app-layout>
        <template #header>
        </template>
    <div class="grid grid-cols-12 mt-7 gap-4">
        <div class="col-start-5 col-span-4">
          
        <h3 class="mt-4 mb-4 text-gray-500 font-semibold text-center text-3xl">{{__('Followers:')}}</h3>
        
<div v-if="followers.length>0" class="">

                <div v-for="follower in followers" :key="follower.id" class="flex flex-col mb-3">
                    <div class="flex flex-row justify-around">
                        <div class="flex flex-row ">
                        <inertia-link :href="route('user.profile',follower.username)"><img :src="follower.profile_photo_url " alt="avatar" class="rounded-full h-10 w-10 me-3"></inertia-link> 
                            <div class="flex flex-col self-center">
                            <inertia-link :href="route('user.profile',follower.username)" class="text-base hover:underline whitespace-nowrap">{{follower.username}}</inertia-link>
                                <h3 class="text-sm text-gray-500 truncate whitespace-nowrap" style="max-width: 25ch">{{follower.bio}}</h3>
                            </div>
                        </div>
                        <div class="self-center">
                                    <follow-button ref="followButtonn" :profile="follower" :isFollowUser="follower.isFollow" ></follow-button>
                                </div>
                    </div>
                </div>
<!-- 
                <div class="col-span-3 mt-10">
                    {{ $followers->links() }}
                </div> -->
            </div>

            <div v-else class="my-10 text-center">
                <p class="font-semibold">{{__('Nothing to show right now!')}}</p>
            </div>

        </div>
    </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import alert from '@/Shared/alert'
       import followButton from '@/Shared/followButton'
    export default {
        components: {
            AppLayout,
            JetButton,
            alert,
            followButton
        },
        props:{followers:Object},
        data(){
            return{
                isFollow:false
            }
        },
        methods:{
            followUser(){

            }
        }
    }

</script>

<template>
    <app-layout>
        <template #header>
        </template>
    <div class="grid grid-cols-12 mt-7 gap-4">
        <div class="col-start-5 col-span-4">
          
        <h3 class="mt-4 mb-4 text-gray-500 font-semibold text-center text-3xl">{{__('following:')}}</h3>
        
<div v-if="following.length>0" class="">

                <div v-for="follow in following" :key="follow.id" class="flex flex-col mb-3">
                    <div class="flex flex-row justify-around">
                        <div class="flex flex-row ">
                        <inertia-link :href="route('user.profile',follow.username)"><img :src="follow.profile_photo_url " alt="avatar" class="rounded-full h-10 w-10 me-3"></inertia-link> 
                            <div class="flex flex-col self-center">
                            <inertia-link :href="route('user.profile',follow.username)" class="text-base hover:underline whitespace-nowrap">{{follow.username}}</inertia-link>
                                <h3 class="text-sm text-gray-500 truncate whitespace-nowrap" style="max-width: 25ch">{{follow.bio}}</h3>
                            </div>
                        </div>
                        <div class="self-center">
                                    <follow-button ref="followButtonn" :profile="follow" :isFollowUser="isFollow" ></follow-button>
                                </div>
                    </div>
                </div>
<!-- 
                <div class="col-span-3 mt-10">
                    {{ $following->links() }}
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
        props:{following:Object},
        data(){
            return{
                isFollow:true
            }
        },
        methods:{
            followUser(){

            }
        }
    }

</script>

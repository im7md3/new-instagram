<template>
    <app-layout>
        <template #header>
        </template>
        <div class="grid grid-cols-12 mt-7 gap-4">
            <div class="col-start-5 col-span-4">
                <span v-if="profile.status=='private'">
                <h3 class="mt-4 mb-4 text-gray-500 font-semibold text-center text-3xl">
                    {{ __('Follow requests:') }}</h3>


                <span v-if="requests.length>0">

                    <div v-for="req in requests" :key="req.id" class="flex flex-col mb-3">
                        <div class="flex flex-row justify-around">
                            <div class="flex flex-row ">
                                <inertia-link :href="route('user.profile',req.username)"><img
                                        :src="req.profile_photo_url" alt="avatar" class="rounded-full h-10 w-10 me-3">
                                </inertia-link>
                                <div class="flex flex-col self-center">
                                    <inertia-link :href="route('user.profile',req.username)"
                                        class="text-base hover:underline whitespace-nowrap">{{ req.username }}
                                    </inertia-link>
                                    <h3 class="text-sm text-gray-500 truncate whitespace-nowrap"
                                        style="max-width: 25ch">{{ req.bio }}</h3>
                                </div>
                            </div>

                            <div v-if="profile.status=='private'" class="self-center">
                                <inertia-link :href="route('accept',req.id)" methed="POST" perserve-scroll as="button"
                                    class="text-blue-500 font-semibold hover:text-blue-400">{{ __('Accept') }}</inertia-link>
                            </div>
                            <div class="self-center">
                                <follow-button ref="followButtonn" :profile="req" :isFollowUser="req.isFollow" @changeFollowers="changeFollowers"></follow-button>
                            </div>

                        </div>
                    </div>

                </span>
                <!-- <div class="col-span-3 mt-10">
                    {{ $requests->links() }}
                </div> -->

                <div v-else class="my-10 text-center">
                    <p class="font-semibold">{{ __('Nothing to show right now!') }}</p>
                </div>
</span>

                <h3 class="mt-4 mb-4 text-gray-500 font-semibold text-center text-3xl">
                    {{ __('Pending sent requests:') }}</h3>


                <span v-if="pendings.length>0">

                    <div v-for="req in pendings" :key="req.id" class="flex flex-col mb-3">
                        <div class="flex flex-row justify-around">
                            <div class="flex flex-row ">
                                <inertia-link :href="route('user.profile',req.username)"><img
                                        :src="req.profile_photo_url" alt="avatar" class="rounded-full h-10 w-10 me-3">
                                </inertia-link>
                                <div class="flex flex-col self-center">
                                    <inertia-link :href="route('user.profile',req.username)"
                                        class="text-base hover:underline whitespace-nowrap">{{ req.username }}
                                    </inertia-link>
                                    <h3 class="text-sm text-gray-500 truncate whitespace-nowrap"
                                        style="max-width: 25ch">{{ req.bio }}</h3>
                                </div>
                            </div>
                            <div class="self-center">
                                <button
                                    class="bg-blue-500 rounded-lg shadow px-2 py-1 text-white whitespace-nowrap">{{ __('pending') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </span>
                <!-- <div class="col-span-3 mt-10">
                    {{ $pendings->links() }}
                </div> -->

                <div v-else class="my-10 text-center">
                    <p class="font-semibold">{{ __('Nothing to show right now!') }}</p>
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
        props: {
            profile: Object,
            requests: Object,
            pendings: Object
        },
        data() {
            return {
                
            }
        },
        methods: {
            acceptFollow() {
                axios.post()
            }
        }
    }

</script>

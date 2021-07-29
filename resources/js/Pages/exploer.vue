<template>
    <app-layout>
        <template #header>
            
        </template>
        <h3 class="mt-4 mb-4 text-gray-500 font-semibold text-center text-3xl">
                    {{ __('Explore') }}</h3>
    <div class="max-w-4xl my-0 mx-auto">    
        <div class="grid grid-cols-3 gap-4 mx-0 mt-0 mb-10">  
          
        <div v-for="post in posts" :key="post.id" class="post">
        <inertia-link :href="route('posts.show',post.id)" class="w-full h-full"><img :src="$page.props.asset + post.image"
                class="w-full h-full object-cover">
            <div class="post-info">
                <ul>
                    <li class="inline-block font-semibold mx-7"><span class="absolute h-1 w-1 overflow-hidden">{{__('Likes:')}}</span><i
                            class="fas fa-heart" aria-hidden="true"></i> {{post.comments_count}}</li>
                    <li class="inline-block font-semibold"><span class="absolute h-1 w-1 overflow-hidden">{{__('Comments:')}}</span><i
                            class="fas fa-comment" aria-hidden="true"></i> {{post.liked_by_users_count}}</li>
                </ul>
            </div>
        </inertia-link>
        </div>
<!--         <div class="col-span-3 mt-10">
            {{ $posts->links() }}
        </div> -->
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
        props:{profile:Object,posts:Object},
        data(){
            return{
                
            }
        },
        methods:{

        }
    }

</script>

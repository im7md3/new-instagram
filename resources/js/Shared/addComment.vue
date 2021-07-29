<template>
    <form v-if="$page.props.user" method="post" autocomplete="off" @submit.prevent="addComment">
        <div class="flex flex-row items-center justify-between">
            <input class="w-full outline-none border-none py-1.5 px-2 text-sm" type="text" :id="'comment'+post.id"
                :placeholder="__('Add Comment')" v-model="form.comment" autofocus />
            <button
                class="px-2 py-1.5 text-blue-500 border border-blue-500 font-semibold hover:bg-blue-500 hover:text-white text-sm "
                type="submit">{{ __('Post') }}</button>
        </div>
    </form>

    <span v-else>
        <inertia-link :href="route('login')" class="text-blue-500 text-sm">
            {{ __('Log In') }}</inertia-link> 
        <span class="text-sm">{{ __(' to like or comment') }}</span>
    </span>
</template>

<script>
    export default {
        props: {
            post: Object,
        },
        data() {
            return {
                form: this.$inertia.form({
                    post_id: this.post.id,
                    comment: ""
                })
            }
        },
        methods: {
            addComment() {
                this.form.post(route('comments.store'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.form.reset();
                    }
                })
            },
        },

    }

</script>

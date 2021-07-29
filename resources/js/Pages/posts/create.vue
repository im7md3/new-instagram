<template>
    <app-layout>
        <template #header>
            <div class="flex justify-center">
                <h1 class="text-2xl md:text-5xl mt-7"> {{ __('Add New Post') }}</h1>
            </div>
        </template>
<div class="mx-auto max-w-4xl">
        <alert></alert>

        <div class="grid grid-col-5 mt-7">
            
            <form class="col-span-3 " enctype="multipart/form-data" @submit.prevent="submit"
                autocomplete="off">
                <div>
                    <jet-label :value="__('Caption')" />
                    <textarea class="block mt-1 w-full px-2 " type="textarea" v-model="form.post_caption"
                        autofocus ></textarea>
                        <span class="text-red-600" v-if="form.errors.post_caption">{{ form.errors.post_caption }}</span>
                </div>

                <div class="mt-4">
                    <jet-label :value="__('Image')" />
                    <jet-input id="image" class="block mt-1 w-full bg-white p-2" type="file" 
                         autofocus required @change="fileAdded"/>
                        <span class="text-red-600" v-if="form.errors.image">{{ form.errors.image }}</span>
                </div>
                <img v-if="form.image" id="cover-image-thumb" class="w-96 h-72" >

                <jet-button class="mt-4">
                    {{ __('Publish') }}
                </jet-button>
            </form>
        </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetButton from '@/Jetstream/Button'
    import alert from '@/Shared/alert'
    export default {
        components: {
            AppLayout,
            JetInput,
            JetLabel,
            JetButton,
            alert
        },
        data(){
            return{
                content_image:'',
                form:this.$inertia.form({
                    post_caption:'',
                    image:'',
                })
            }
        },
        methods:{
            fileAdded(){

                const input = document.getElementById('image');
                if (input.files && input.files[0]) {
                    this.form.image = input.files[0];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('cover-image-thumb').setAttribute('src', e.target.result);
                    };
                    this.content_image=input.files[0].name;
                    reader.readAsDataURL(input.files[0]);
                }
            },
            submit(){
                this.form.post(route('posts.store'),{
                    preventScroll:true,
                    onSuccess:()=>{
                        this.form.reset()
                        document.getElementById('image').value=null;
                    }
                })
            }
        }
    }

</script>

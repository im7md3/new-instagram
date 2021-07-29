<template>
    <div class="min-h-screen flex flex-row sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="">
            <slot name="logo" />
        </div>
        <div class="flex flex-col">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <slot />
            </div>
        

    <div v-if="route().current('login')" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg flex justify-center items-center">
     <span class="text-sm text-gray-600 ">{{__('Don\'t have an account?')}}<inertia-link :href=" route('register') " class="text-blue-700 hover:text-blue-900 text-base font-bold mx-2 ">{{__('Sign Up')}}</inertia-link></span>   
    </div>
</div>
    </div>
</template>

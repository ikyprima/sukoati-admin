<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
        

            <div class="py-2">
                <nav class="block">
                    <ul class="flex pl-0 rounded list-none flex-wrap">
                        <li v-if="currentPage !== 1" >
                            <Link class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid  "
                            :class="[currentPage === 1 ? 'border-emerald-200 text-white bg-emerald-200' : 'border-emerald-500 bg-white text-emerald-500']"
                            :href="firstPageUrl" preserve-scroll
                            >
                            <i class="fas fa-chevron-left -ml-px"></i>
                            <i class="fas fa-chevron-left -ml-px"></i>
                            
                            </Link>
                        </li>
                        <li v-else>
                            <a class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid  "
                            :class="[currentPage === 1 ? 'border-emerald-200 text-white bg-emerald-200' : 'border-emerald-500 bg-white text-emerald-500']"
                            
                            >
                            <i class="fas fa-chevron-left -ml-px"></i>
                            <i class="fas fa-chevron-left -ml-px"></i>
                            
                            </a>
                        </li>
                        <template v-for="(link, k) in links" :key="k">
                        
                            <li>
                                <a v-if="link.url === null && link.label.includes('Previous')"
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-emerald-200 text-white bg-emerald-200">
                                    <i class="fas fa-chevron-left -ml-px"></i>

                                </a>
                                <a v-else-if="link.url === null && link.label.includes('Next')"
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-emerald-200 text-white bg-emerald-200">
                                    <i class="fas fa-chevron-right -ml-px"></i>
                                </a>
                                <a v-else-if="link.url === null"
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-emerald-200 text-white bg-emerald-200">
                                    <i v-if="link.label != '...'" class="fas fa-chevron-left -ml-px"></i>
                                    <p v-else> {{ link.label }}</p>
                                </a>
                                <Link v-else-if="link.url != null && link.label.includes('Previous')" :href="link.url" preserve-scroll
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-emerald-500 bg-white text-emerald-500">
                                <i class="fas fa-chevron-left -ml-px"></i>
                                </Link>
                                <Link v-else-if="link.url != null && link.label.includes('Next')" :href="link.url" preserve-scroll
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-emerald-500 bg-white text-emerald-500">
                                <i class="fas fa-chevron-right -mr-px"></i>
                                </Link>
                                <Link v-else
                                    class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-emerald-500 "
                                    :class="[link.active === true ? 'text-white bg-emerald-500' : 'bg-white text-emerald-500']"
                                    :href="link.url" v-html="link.label" preserve-scroll>
                                </Link>
                            </li>


                        </template>
                        <li v-if=" currentPage === lastPage ">
                            <a class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-emerald-200 bg-emerald-200 text-white ">
                            <i class="fas fa-chevron-right -mr-px"></i>
                            <i class="fas fa-chevron-right -mr-px"></i>
                            </a>
                        </li>
                        <li v-else>
                            <Link class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid  "
                            :class="[currentPage === lastPage ? 'border-emerald-200 text-white bg-emerald-200' : 'border-emerald-500 bg-white text-emerald-500']"
                            :href="lastPageUrl" preserve-scroll
                            >
                            <i class="fas fa-chevron-right -ml-px"></i>
                            <i class="fas fa-chevron-right -ml-px"></i>
                            
                            </Link>
                            
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>
    
<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
        Link
    },
    props: {
        links: Array,
        currentPage: Number,
        firstPageUrl: String,
        lastPage: Number,
        lastPageUrl: String
    },
}
</script> 
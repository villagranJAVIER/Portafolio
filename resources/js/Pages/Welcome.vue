

<template>
    <Head title="welcome"/>

    <div class="
        grid
        grid-cols-2
        text-right
        py-10
        px-72
        bg-gray-800
        text-gray-300
    ">
        <div>
            <jet-application-mark class="h-12 w-auto"></jet-application-mark>
        </div>
        <div v-if="canLogin">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-base underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="text-base underline place-self-end ml-4">
                    Register
                </Link>
            </template>
        </div>
    </div>


    <Section class="
        bg-gray-800
        pt-16
        h-screen
    ">
        <div class="h-2/3 flex flex-wrap content-between border-gray-600 pb-36">
            <p class="
                border-b-2
                font-bold
                border-gray-400
                pb-3
                text-2xl
                text-gray-300
                uppercase
            ">
                Hola, soy Javier Villagrán y soy desarrollador web!!!
            </p>

            <div class="flex items-end border-b-2 border-gray-500 pb-2">
                <p class="
                    font-bold
                    mr-5
                    text-gray-500
                    text-xl
                ">
                    ¿Quieres saber más?
                </p>
                <jet-button class="
                    bg-green-400
                    rounded
                    font-bold
                    text-sm
                    text-gray-800
                    hover:bg-green-500"
                    @click="contacting = true"
                >
                {{
                    $page.props.flash.contacted ? 'Gracias' : 'Constactame'
                }}
                </jet-button>
            </div>
        </div>

        <div class="animate-pulse mt-3 text-gray-300 text-center text-9xl">
            <a href="#skills">&#8675;</a>
        </div>
    </Section>

    <Section id="skills" class="bg-gray-200 text-gray-800 h-screen">
        <h2 class="text-6xl font-bold pt-3">Skills</h2>

        <div class="grid grid-cols-2">
            <div v-for="skill in skills">
                <Skill :background="skill.color">
                    {{ skill.name }}
                </Skill>
            </div>
        </div>

        <div class="flex justify-center mt-10">
            <jet-button class="
                bg-indigo-800
                rounded
                font-bold
                text-sm
                text-gray-200
                hover:bg-indigo-700"
                @click="contacting = true"
            >
                Ponerse en contacto
            </jet-button>
        </div>

    </Section>
    
    <Section class="bg-gray-600
    text-gray-200 h-screen
    ">
        <h2 class="text-6xl font-bold pt-3">Projects</h2>

        <div v-for="(project, index) in projects">
            <Project
                :title="project.title"
                :description="project.description"
                :color="project.color"
            >
                <component :is="componentName(index)"></component>
               
            </Project>
        </div>

        <div class="flex justify-center mt-10">
            <jet-button class="
                bg-purple-100
                rounded
                font-bold
                text-sm
                text-gray-800
                hover:bg-purple-200"
                @click="contacting = true"
            >
                Saber más
            </jet-button>
        </div>

    </Section>

    <Section class="
        flex
        justify-between
        bg-gray-800
        text-gray-300
        text-xl
    ">
        <p>&copy; JavierVi. All rights reserved.</p>
        <div class="flex justify-evenly items-center">
            <Link class="border-b pb-1 px-2 hover:text-gray-50" href="#" target="_blank">
                GitHub
            </Link> 

            <Link class="border-b pb-1 px-2 hover:text-gray-50" href="#" target="_blank">
                Twitter
            </Link>

            <Link class="border-b pb-1 px-2 hover:text-gray-50" href="#" target="_blank">
                StackOverflow
            </Link>
        </div>
    </Section>

    <jet-modal :show="contacting" closeable="true" @close="contacting = null">
        
        

        <div class="bg-gray-50 shadow-2xl p-8">
            <p class="text-gray-600 text-2xl font-extrabold text-center">
                Déjame saber algunos detalles
            </p>

        </div>

        <form
                class="flex flex-col items-center p-16"
                @submit.prevent="submit"
            >
                <jet-input
                    class="px-5 py-3 w-96 border border-gray-600 rounded"
                    type="email"
                    name="email"
                    placeholder="Tu email"
                    v-model="form.email"
                ></jet-input>

                <jet-input-error :message="form.errors.email"/>

                <textarea
                    class="px-5 py-3 w-96 border border-gray-600 rounded mt-5"
                    name="message"
                    placeholder="Los detalles :D"
                    v-model="form.message"
                ></textarea>

                <jet-input-error :message="form.errors.message"/>

                <jet-button
                    class="px-5 py-3 mt-5 w-96 bg-purple-400 justify-center rounded-xl text-sm"
                    :disabled="form.processing"
                >
                    <span class="animate-spin mr-1" v-show="form.processing">
                        &#9696;
                    </span>

                    <span v-show="!form.processing">
                        Get in touch
                    </span>
                </jet-button>
            </form>

    </jet-modal>

</template>


<script>
    import { defineComponent, defineAsyncComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import JetApplicationMark from '@/Components/ApplicationMark.vue'
    import JetButton from '@/Components/Button.vue'
    import JetModal from '@/Components/Modal.vue'
    import JetInput from '@/Components/Input.vue'
    import JetInputError from '@/Components/InputError.vue'

    import Section from '@/Componentes/Section.vue'
    import Skill from '@/Componentes/Skill.vue'
    import Project from '@/Componentes/Project.vue'


    import { LockClosedIcon } from '@heroicons/vue/24/solid'

    export default defineComponent({
        components: {
            Head,
            Link,
            JetApplicationMark, 
            JetButton,
            JetModal,
            JetInput,
            JetInputError,

            Section,
            Skill,
            Project,
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            skills: Object,
            projects: Object,
        },

        methods: {
            componentName(index) {
                return defineAsyncComponent(() =>
                    import (
                        '@heroicons/vue/24/solid'
                        // + this.projects[index].icon_name
                        // + 'Icon.js'
                    )
                )
            },
            submit() {
                this.form.post(route('contact'));
            }
        },

        data(){
            return {
                contacting: null,
                form: this.$inertia.form({
                    'email': '',
                    'message': '',
                }),
            }
        }


    })
    
</script>
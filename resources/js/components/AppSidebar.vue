<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { computed } from 'vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, ReceiptText } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

// Importación de rutas (Asegúrate de que estos archivos existan en tu proyecto)
import students from '@/routes/admin/students';
import academic_periods from '@/routes/admin/academic_periods';
import study_programs from '@/routes/admin/study_programs';
import study_plans from '@/routes/admin/study_plans';
import courses from '@/routes/admin/courses';
import course_sections from '@/routes/admin/course_sections';
import { route } from 'ziggy-js';

const page = usePage();

// 1. Acceso Reactivo al Usuario
const user = computed(() => page.props.auth.user);

// 2. Computed para verificar roles
const isAdmin = computed(() => {
    const roles = user.value?.roles as string[] | undefined;
    return Array.isArray(roles) && roles.includes('admin');
});

const isStudent = computed(() => {
    const roles = user.value?.roles as string[] | undefined;
    return Array.isArray(roles) && roles.includes('estudiante');
});

const isTreasury = computed(() => {
    const roles = user.value?.roles as string[] | undefined;
    return Array.isArray(roles) && roles.includes('tesoreria');
});

const isTeacher = computed(() => {
    const roles = user.value?.roles as string[] | undefined;
    return Array.isArray(roles) && roles.includes('docente');
});

// 3. Menús Estáticos
const adminNavItems: NavItem[] = [
    {
        title: 'Subir Alumnos 2025',
        href: '/subir-alumnos-2025',
        icon: Folder,
    },
    {
        title: 'Estudiantes',
        href: students.index().url,
        icon: Folder,
    },
    {
        title: 'Períodos Académicos',
        href: academic_periods.index().url,
        icon: Folder,
    },
    {
        title: 'Programas de Estudio',
        href: study_programs.index().url,
        icon: Folder,
    },
    {
        title: 'Planes de Estudio',
        href: study_plans.index().url,
        icon: Folder,
    },
    {
        title: 'Cursos',
        href: courses.index().url,
        icon: Folder,
    },
    {
        title: 'Secciones de Curso',
        href: course_sections.index().url,
        icon: Folder,
    },
    {
        title: 'Catálogo de Competencias',
        href: '/admin/competencias', // Definiremos esta ruta ahora
        icon: BookOpen, // Usa un icono de catálogo o libro
    },
];

const studentNavItems: NavItem[] = [
    {
        title: 'Ficha Socioeconómica',
        href: '/ficha-socioeconomica',
        icon: Folder,
    },
    {
        title: 'Mis Pagos / Tesorería', // <-- Añadimos este
        href: '/mis-pagos',
        icon: BookOpen, // O cualquier icono que te guste
    },
    {
        title: 'Matrícula',
        href: '/matricula',
        icon: Folder,
    },
];

const treasuryNavItems = [
    {
        title: 'Validar Pagos',
        href: '/tesoreria/validar-pagos', // La ruta que creamos en web.php
        icon: LayoutGrid, // Puedes usar ReceiptText si lo importaste
    },
];

const teacherNavItems = [
    {
        title: 'Mis Cursos y Notas',
        href: route('teacher.sections.index'),
        icon: BookOpen,
    },
];


// 4. Menú Principal Dinámico
const mainNavItems = computed(() => {
    const items: NavItem[] = [
        {
            title: 'Dashboard',
            href: dashboard(),
            icon: LayoutGrid,
        },
    ];

    // Usamos .value para leer los computed
    if (isAdmin.value) {
        items.push(...adminNavItems);
    }

    if (isStudent.value) {
        items.push(...studentNavItems);
    }

    if (isTreasury.value) {
        items.push(...treasuryNavItems);
    }

    if (isTeacher.value) {
        items.push(...teacherNavItems);
    }

    return items;
});

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <!-- Pasamos la lista dinámica -->
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

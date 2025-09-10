<template>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <section class="py-20 brand-gradient text-white">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-5xl font-bold mb-6">Careers at HMI</h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto">
                    Join our mission to advance financial inclusion and empower
                    communities across Afghanistan
                </p>
            </div>
        </section>

        <!-- Why Work With Us -->
        <section class="py-16" style="background-color: var(--brand-cream)">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold brand-text mb-8 text-center">
                    Why Work With Us?
                </h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="text-4xl mb-4 brand-text">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">
                            Meaningful Impact
                        </h3>
                        <p class="text-slate-600">
                            Make a real difference in the lives of farmers and
                            entrepreneurs across Afghanistan
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-4 brand-text">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">
                            Collaborative Culture
                        </h3>
                        <p class="text-slate-600">
                            Work with passionate professionals in a supportive
                            and inclusive environment
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-4 brand-text">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">
                            Growth Opportunities
                        </h3>
                        <p class="text-slate-600">
                            Develop your skills and advance your career in the
                            microfinance sector
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Current Openings -->
        <section class="py-16" style="background-color: var(--brand-wheat)">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold brand-text mb-8 text-center">
                    Current Job Openings
                </h2>
                <div class="space-y-6">
                    <div
                        v-for="job in jobs"
                        :key="job.id"
                        class="rounded-xl p-6 card-hover"
                        style="
                            background-color: var(--brand-cream);
                            border: 1px solid var(--brand-sage);
                        "
                    >
                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4"
                        >
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold mb-2">
                                    {{ job.title }}
                                </h3>
                                <div
                                    class="flex flex-wrap items-center gap-4 text-sm text-slate-600 mb-3"
                                >
                                    <span class="flex items-center gap-1">
                                        <i
                                            class="fa-solid fa-map-marker-alt"
                                        ></i>
                                        {{ job.location }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-briefcase"></i>
                                        {{ job.type }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-calendar"></i>
                                        Posted {{ job.posted }}
                                    </span>
                                </div>
                                <p class="text-slate-700 mb-4">
                                    {{ job.description }}
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        v-for="skill in job.skills"
                                        :key="skill"
                                        class="px-3 py-1 text-xs rounded-full"
                                        style="
                                            background-color: var(--brand-sage);
                                            color: var(--brand-earth);
                                        "
                                    >
                                        {{ skill }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <button class="btn btn-primary">
                                    <i class="fa-solid fa-eye mr-2"></i>
                                    View Details
                                </button>
                                <button class="btn btn-secondary">
                                    <i class="fa-solid fa-paper-plane mr-2"></i>
                                    Apply Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Application Process -->
        <section class="py-16" style="background-color: var(--brand-sage)">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold brand-text mb-8 text-center">
                    Application Process
                </h2>
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-white font-bold text-xl"
                            style="background-color: var(--brand-earth)"
                        >
                            1
                        </div>
                        <h3 class="font-semibold mb-2">Submit Application</h3>
                        <p class="text-sm text-slate-600">
                            Send your CV and cover letter through our portal
                        </p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-white font-bold text-xl"
                            style="background-color: var(--brand-earth)"
                        >
                            2
                        </div>
                        <h3 class="font-semibold mb-2">Initial Review</h3>
                        <p class="text-sm text-slate-600">
                            Our HR team reviews your application
                        </p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-white font-bold text-xl"
                            style="background-color: var(--brand-earth)"
                        >
                            3
                        </div>
                        <h3 class="font-semibold mb-2">Interview</h3>
                        <p class="text-sm text-slate-600">
                            Meet with our team for a comprehensive interview
                        </p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-white font-bold text-xl"
                            style="background-color: var(--brand-earth)"
                        >
                            4
                        </div>
                        <h3 class="font-semibold mb-2">Decision</h3>
                        <p class="text-sm text-slate-600">
                            Receive feedback and join our team
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits -->
        <section class="py-16" style="background-color: var(--brand-cream)">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold brand-text mb-8 text-center">
                    Employee Benefits
                </h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl mb-3 brand-text">
                            <i class="fa-solid fa-medal"></i>
                        </div>
                        <h3 class="font-semibold mb-2">Competitive Salary</h3>
                        <p class="text-sm text-slate-600">
                            Market-competitive compensation packages
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl mb-3 brand-text">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <h3 class="font-semibold mb-2">
                            Training & Development
                        </h3>
                        <p class="text-sm text-slate-600">
                            Continuous learning and skill development
                            opportunities
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl mb-3 brand-text">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <h3 class="font-semibold mb-2">Health Insurance</h3>
                        <p class="text-sm text-slate-600">
                            Comprehensive health coverage for you and your
                            family
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl mb-3 brand-text">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <h3 class="font-semibold mb-2">Work-Life Balance</h3>
                        <p class="text-sm text-slate-600">
                            Flexible working arrangements and paid time off
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref } from "vue";

const jobs = [
    {
        id: 1,
        title: "Loan Officer",
        location: "Kabul",
        type: "Full-time",
        posted: "2 days ago",
        description:
            "Responsible for managing loan portfolios, client relationships, and ensuring compliance with HMI policies.",
        skills: [
            "Finance",
            "Customer Service",
            "Risk Assessment",
            "Communication",
        ],
    },
    {
        id: 2,
        title: "Field Coordinator",
        location: "Herat",
        type: "Full-time",
        posted: "1 week ago",
        description:
            "Coordinate field operations, manage regional teams, and ensure effective service delivery in rural areas.",
        skills: [
            "Project Management",
            "Team Leadership",
            "Rural Development",
            "Monitoring & Evaluation",
        ],
    },
    {
        id: 3,
        title: "IT Support Specialist",
        location: "Kabul",
        type: "Full-time",
        posted: "2 weeks ago",
        description:
            "Provide technical support for HMI's IT systems, maintain databases, and ensure system security.",
        skills: [
            "IT Support",
            "Database Management",
            "System Security",
            "Troubleshooting",
        ],
    },
    {
        id: 4,
        title: "Marketing Officer",
        location: "Kabul",
        type: "Full-time",
        posted: "3 weeks ago",
        description:
            "Develop and implement marketing strategies to promote HMI's services and reach new clients.",
        skills: [
            "Marketing",
            "Digital Media",
            "Content Creation",
            "Brand Management",
        ],
    },
];
</script>

<template>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <section class="py-20 brand-gradient text-white">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-5xl font-bold mb-6">Contact Us</h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto">
                    Get in touch with our team. We're here to help and answer
                    any questions you may have.
                </p>
            </div>
        </section>

        <!-- Contact Information & Form -->
        <section class="py-16" style="background-color: var(--brand-cream)">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid lg:grid-cols-2 gap-12">
                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-3xl font-bold brand-text mb-8">
                            Get in Touch
                        </h2>
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="text-2xl brand-text mt-1">
                                    <i class="fa-solid fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg mb-2">
                                        Head Office
                                    </h3>
                                    <p class="text-slate-600">
                                        Street 15, District 3<br />
                                        Kabul, Afghanistan<br />
                                        Postal Code: 1001
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="text-2xl brand-text mt-1">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg mb-2">
                                        Phone
                                    </h3>
                                    <p class="text-slate-600">
                                        +93 123 456 789<br />
                                        +93 987 654 321
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="text-2xl brand-text mt-1">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg mb-2">
                                        Email
                                    </h3>
                                    <p class="text-slate-600">
                                        info@hasselmfi.org<br />
                                        support@hasselmfi.org
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="text-2xl brand-text mt-1">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg mb-2">
                                        Business Hours
                                    </h3>
                                    <p class="text-slate-600">
                                        Saturday - Thursday: 8:00 AM - 5:00
                                        PM<br />
                                        Friday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="mt-8">
                            <h3 class="font-semibold text-lg mb-4">
                                Follow Us
                            </h3>
                            <div class="flex gap-4">
                                <a
                                    href="#"
                                    class="w-12 h-12 rounded-full flex items-center justify-center text-white"
                                    style="background-color: var(--brand-earth)"
                                >
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <a
                                    href="#"
                                    class="w-12 h-12 rounded-full flex items-center justify-center text-white"
                                    style="background-color: var(--brand-earth)"
                                >
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                                <a
                                    href="#"
                                    class="w-12 h-12 rounded-full flex items-center justify-center text-white"
                                    style="background-color: var(--brand-earth)"
                                >
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                                <a
                                    href="#"
                                    class="w-12 h-12 rounded-full flex items-center justify-center text-white"
                                    style="background-color: var(--brand-earth)"
                                >
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div>
                        <h2 class="text-3xl font-bold brand-text mb-8">
                            Send us a Message
                        </h2>
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        for="firstName"
                                        class="block text-sm font-medium text-slate-700 mb-2"
                                        >First Name *</label
                                    >
                                    <input
                                        type="text"
                                        id="firstName"
                                        v-model="form.firstName"
                                        required
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    />
                                </div>
                                <div>
                                    <label
                                        for="lastName"
                                        class="block text-sm font-medium text-slate-700 mb-2"
                                        >Last Name *</label
                                    >
                                    <input
                                        type="text"
                                        id="lastName"
                                        v-model="form.lastName"
                                        required
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    for="email"
                                    class="block text-sm font-medium text-slate-700 mb-2"
                                    >Email *</label
                                >
                                <input
                                    type="email"
                                    id="email"
                                    v-model="form.email"
                                    required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                />
                            </div>

                            <div>
                                <label
                                    for="phone"
                                    class="block text-sm font-medium text-slate-700 mb-2"
                                    >Phone</label
                                >
                                <input
                                    type="tel"
                                    id="phone"
                                    v-model="form.phone"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                />
                            </div>

                            <div>
                                <label
                                    for="subject"
                                    class="block text-sm font-medium text-slate-700 mb-2"
                                    >Subject *</label
                                >
                                <select
                                    id="subject"
                                    v-model="form.subject"
                                    required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                >
                                    <option value="">Select a subject</option>
                                    <option value="loan-inquiry">
                                        Loan Inquiry
                                    </option>
                                    <option value="partnership">
                                        Partnership
                                    </option>
                                    <option value="career">
                                        Career Opportunity
                                    </option>
                                    <option value="general">
                                        General Inquiry
                                    </option>
                                    <option value="complaint">Complaint</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div>
                                <label
                                    for="message"
                                    class="block text-sm font-medium text-slate-700 mb-2"
                                    >Message *</label
                                >
                                <textarea
                                    id="message"
                                    v-model="form.message"
                                    required
                                    rows="5"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="Please describe your inquiry in detail..."
                                ></textarea>
                            </div>

                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="w-full btn btn-primary py-4 text-lg"
                            >
                                <i
                                    v-if="!isSubmitting"
                                    class="fa-solid fa-paper-plane mr-2"
                                ></i>
                                <i
                                    v-else
                                    class="fa-solid fa-spinner fa-spin mr-2"
                                ></i>
                                {{
                                    isSubmitting ? "Sending..." : "Send Message"
                                }}
                            </button>
                        </form>

                        <!-- Success Message -->
                        <div
                            v-if="showSuccess"
                            class="mt-6 p-4 rounded-lg text-green-800"
                            style="background-color: #dcfce7"
                        >
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-check-circle"></i>
                                <span class="font-medium"
                                    >Message sent successfully!</span
                                >
                            </div>
                            <p class="text-sm mt-1">
                                Thank you for contacting us. We'll get back to
                                you within 24 hours.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Regional Offices -->
        <section class="py-16" style="background-color: var(--brand-wheat)">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold brand-text mb-8 text-center">
                    Regional Offices
                </h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        v-for="office in regionalOffices"
                        :key="office.id"
                        class="rounded-xl p-6 card-hover"
                        style="
                            background-color: var(--brand-cream);
                            border: 1px solid var(--brand-sage);
                        "
                    >
                        <h3 class="text-xl font-semibold brand-text mb-4">
                            {{ office.city }}
                        </h3>
                        <div class="space-y-2 text-sm text-slate-600">
                            <p>
                                <i class="fa-solid fa-map-marker-alt mr-2"></i
                                >{{ office.address }}
                            </p>
                            <p>
                                <i class="fa-solid fa-phone mr-2"></i
                                >{{ office.phone }}
                            </p>
                            <p>
                                <i class="fa-solid fa-envelope mr-2"></i
                                >{{ office.email }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref } from "vue";

const isSubmitting = ref(false);
const showSuccess = ref(false);

const form = ref({
    firstName: "",
    lastName: "",
    email: "",
    phone: "",
    subject: "",
    message: "",
});

const submitForm = async () => {
    isSubmitting.value = true;

    // Simulate API call
    await new Promise((resolve) => setTimeout(resolve, 2000));

    isSubmitting.value = false;
    showSuccess.value = true;

    // Reset form
    form.value = {
        firstName: "",
        lastName: "",
        email: "",
        phone: "",
        subject: "",
        message: "",
    };

    // Hide success message after 5 seconds
    setTimeout(() => {
        showSuccess.value = false;
    }, 5000);
};

const regionalOffices = [
    {
        id: 1,
        city: "Herat",
        address: "Main Street, Herat City",
        phone: "+93 40 123 456",
        email: "herat@hasselmfi.org",
    },
    {
        id: 2,
        city: "Mazar-i-Sharif",
        address: "Balkh Road, Mazar-i-Sharif",
        phone: "+93 50 123 456",
        email: "mazar@hasselmfi.org",
    },
    {
        id: 3,
        city: "Kandahar",
        address: "Kandahar City Center",
        phone: "+93 30 123 456",
        email: "kandahar@hasselmfi.org",
    },
];
</script>

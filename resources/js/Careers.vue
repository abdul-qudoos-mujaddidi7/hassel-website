<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-green-800 via-green-700 to-green-600 text-white overflow-hidden">
      <!-- Background Pattern -->
      <div class="absolute inset-0 bg-black opacity-20"></div>
      <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 20px 20px;"></div>
      </div>
      
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="text-center">
          <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fadeInUp">
            Careers at <span class="gradient-text">Hassel</span>
          </h1>
          <p class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto animate-fadeInUp" style="animation-delay: 0.2s">
            Join our mission to advance technology solutions and empower businesses through innovation
          </p>
        </div>
      </div>
    </section>

    <!-- Why Work With Us Section -->
    <section class="section-padding bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Why Work With Us?</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Discover what makes Hassel a great place to build your career
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-green-50 to-green-100 card-hover">
            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-4 text-gray-900">Meaningful Impact</h3>
            <p class="text-gray-600">
              Make a real difference in the lives of businesses and entrepreneurs through innovative technology solutions
            </p>
          </div>
          <div class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-emerald-50 to-emerald-100 card-hover">
            <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-4 text-gray-900">Collaborative Culture</h3>
            <p class="text-gray-600">
              Work with passionate professionals in a supportive and inclusive environment that values teamwork
            </p>
          </div>
          <div class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-yellow-50 to-yellow-100 card-hover">
            <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-4 text-gray-900">Growth Opportunities</h3>
            <p class="text-gray-600">
              Develop your skills and advance your career in the technology sector with continuous learning opportunities
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Current Openings Section -->
    <section class="section-padding bg-gradient-bg-organic">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Current Job Openings</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Explore exciting career opportunities and find your next role at Hassel
          </p>
        </div>

        <div class="space-y-6">
          <div
            v-for="job in jobs"
            :key="job.id"
            class="rounded-professional-lg p-8 card-hover bg-white shadow-professional"
          >
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <div class="flex-1">
                <h3 class="text-xl font-semibold mb-2 text-gray-900">{{ job.title }}</h3>
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-3">
                  <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ job.location }}
                  </span>
                  <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                    </svg>
                    {{ job.type }}
                  </span>
                  <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Posted {{ job.posted }}
                  </span>
                </div>
                <p class="text-gray-700 mb-4">{{ job.description }}</p>
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="skill in job.skills"
                    :key="skill"
                    class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800"
                  >
                    {{ skill }}
                  </span>
                </div>
              </div>
              <div class="flex flex-col gap-2">
                <button class="btn btn-primary">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                  View Details
                </button>
                <button class="btn btn-secondary">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                  </svg>
                  Apply Now
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Application Process Section -->
    <section class="section-padding bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Application Process</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Our streamlined hiring process ensures we find the right fit for both you and our team
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-white font-bold text-xl bg-gradient-to-br from-green-600 to-emerald-600">
              1
            </div>
            <h3 class="font-semibold mb-2 text-gray-900">Submit Application</h3>
            <p class="text-sm text-gray-600">
              Send your CV and cover letter through our application portal
            </p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-white font-bold text-xl bg-gradient-to-br from-emerald-600 to-green-600">
              2
            </div>
            <h3 class="font-semibold mb-2 text-gray-900">Initial Review</h3>
            <p class="text-sm text-gray-600">
              Our HR team reviews your application and qualifications
            </p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-white font-bold text-xl bg-gradient-to-br from-yellow-500 to-orange-500">
              3
            </div>
            <h3 class="font-semibold mb-2 text-gray-900">Interview</h3>
            <p class="text-sm text-gray-600">
              Meet with our team for a comprehensive technical and cultural interview
            </p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-white font-bold text-xl bg-gradient-to-br from-green-600 to-emerald-600">
              4
            </div>
            <h3 class="font-semibold mb-2 text-gray-900">Decision</h3>
            <p class="text-sm text-gray-600">
              Receive feedback and join our team if selected
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Benefits Section -->
    <section class="section-padding bg-gradient-bg-organic">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Employee Benefits</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            We offer comprehensive benefits to support our team members' well-being and career growth
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="text-center p-6 rounded-professional-lg bg-white card-hover">
            <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-lg flex items-center justify-center mx-auto mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
              </svg>
            </div>
            <h3 class="font-semibold mb-2 text-gray-900">Competitive Salary</h3>
            <p class="text-sm text-gray-600">
              Market-competitive compensation packages with performance bonuses
            </p>
          </div>
          <div class="text-center p-6 rounded-professional-lg bg-white card-hover">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-green-600 rounded-lg flex items-center justify-center mx-auto mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.083 12.083 0 01.665-6.479L12 14z"/>
              </svg>
            </div>
            <h3 class="font-semibold mb-2 text-gray-900">Training & Development</h3>
            <p class="text-sm text-gray-600">
              Continuous learning opportunities and professional development programs
            </p>
          </div>
          <div class="text-center p-6 rounded-professional-lg bg-white card-hover">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center mx-auto mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
              </svg>
            </div>
            <h3 class="font-semibold mb-2 text-gray-900">Health Insurance</h3>
            <p class="text-sm text-gray-600">
              Comprehensive health coverage for you and your family members
            </p>
          </div>
          <div class="text-center p-6 rounded-professional-lg bg-white card-hover">
            <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-lg flex items-center justify-center mx-auto mb-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
            <h3 class="font-semibold mb-2 text-gray-900">Work-Life Balance</h3>
            <p class="text-sm text-gray-600">
              Flexible working arrangements and generous paid time off policies
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="heading-lg mb-6">Ready to Join Our Team?</h2>
        <p class="text-xl text-green-100 mb-8">
          Don't see a position that matches your skills? We're always looking for talented individuals to join our growing team.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <router-link to="/contact" class="btn btn-cta text-lg px-8 py-4">
            Contact Us
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
          </router-link>
          <router-link to="/about" class="btn border-2 border-white text-white hover:bg-white hover:text-green-600 text-lg px-8 py-4">
            Learn About Us
          </router-link>
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
    title: "Senior Software Developer",
    location: "Remote",
    type: "Full-time",
    posted: "2 days ago",
    description: "Lead development of cutting-edge software solutions using modern technologies and best practices.",
    skills: ["React", "Node.js", "TypeScript", "AWS", "Agile"],
  },
  {
    id: 2,
    title: "DevOps Engineer",
    location: "San Francisco, CA",
    type: "Full-time",
    posted: "1 week ago",
    description: "Manage cloud infrastructure, CI/CD pipelines, and ensure system reliability and scalability.",
    skills: ["AWS", "Docker", "Kubernetes", "Terraform", "Monitoring"],
  },
  {
    id: 3,
    title: "UX/UI Designer",
    location: "New York, NY",
    type: "Full-time",
    posted: "2 weeks ago",
    description: "Create intuitive and engaging user experiences for our digital products and platforms.",
    skills: ["Figma", "User Research", "Prototyping", "Design Systems", "Accessibility"],
  },
  {
    id: 4,
    title: "Product Manager",
    location: "Remote",
    type: "Full-time",
    posted: "3 weeks ago",
    description: "Drive product strategy, roadmap development, and cross-functional team collaboration.",
    skills: ["Product Strategy", "Agile", "Analytics", "Stakeholder Management", "Roadmapping"],
  },
];
</script>
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
            About <span class="gradient-text">Hassel</span>
          </h1>
          <p class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto animate-fadeInUp" style="animation-delay: 0.2s">
            Learn about our mission, history, and the people behind our professional solutions
          </p>
        </div>
      </div>
    </section>

    <!-- Who We Are Section -->
    <section class="section-padding bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Who We Are</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            A leading technology solutions provider dedicated to transforming businesses through innovation
          </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div>
            <p class="text-lg text-gray-600 leading-relaxed mb-6">
              Hassel is a leading technology solutions provider dedicated to advancing 
              digital transformation across businesses. We serve entrepreneurs, enterprises, 
              and communities through innovative, accessible technology solutions.
            </p>
            <p class="text-lg text-gray-600 leading-relaxed mb-8">
              Our commitment to sustainable growth and client-centered impact drives everything 
              we do, from solution design to implementation across diverse industries.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
              <router-link to="/our-work" class="btn btn-primary">
                View Our Work
              </router-link>
              <router-link to="/contact" class="btn btn-secondary">
                Get In Touch
              </router-link>
            </div>
          </div>
          <div class="relative">
            <div class="bg-gradient-to-br from-green-600 to-emerald-600 rounded-professional-lg p-8 text-white">
              <h3 class="text-2xl font-bold mb-4">Our Mission</h3>
              <p class="text-green-100 mb-6">
                To deliver exceptional value through cutting-edge technology, expert guidance, 
                and unwavering commitment to our clients' success.
              </p>
              <div class="space-y-4">
                <div class="flex items-center">
                  <div class="w-2 h-2 bg-white rounded-full mr-3"></div>
                  <span class="text-sm">Innovation-driven solutions</span>
                </div>
                <div class="flex items-center">
                  <div class="w-2 h-2 bg-white rounded-full mr-3"></div>
                  <span class="text-sm">Client-focused approach</span>
                </div>
                <div class="flex items-center">
                  <div class="w-2 h-2 bg-white rounded-full mr-3"></div>
                  <span class="text-sm">Sustainable growth</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Our History Section -->
    <section class="section-padding bg-gradient-bg-organic">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Our History</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            From our founding to becoming a trusted partner in digital transformation, 
            Hassel has grown alongside the businesses we serve.
          </p>
        </div>

        <div class="max-w-5xl mx-auto">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-professional-lg bg-white card-hover shadow-professional">
              <div class="text-5xl font-bold gradient-text mb-4">2013</div>
              <h3 class="text-xl font-semibold mb-4 text-gray-800">Foundation</h3>
              <p class="text-gray-600 leading-relaxed">
                Hassel was established with a vision to serve businesses through 
                innovative technology solutions and digital transformation.
              </p>
            </div>
            <div class="text-center p-8 rounded-professional-lg bg-white card-hover shadow-professional">
              <div class="text-5xl font-bold gradient-text mb-4">2018</div>
              <h3 class="text-xl font-semibold mb-4 text-gray-800">Expansion</h3>
              <p class="text-gray-600 leading-relaxed">
                Extended services to enterprise clients and expanded our team 
                with specialized expertise across multiple technology domains.
              </p>
            </div>
            <div class="text-center p-8 rounded-professional-lg bg-white card-hover shadow-professional">
              <div class="text-5xl font-bold gradient-text mb-4">2024</div>
              <h3 class="text-xl font-semibold mb-4 text-gray-800">Growth</h3>
              <p class="text-gray-600 leading-relaxed">
                Serving over 500+ clients across 10+ industries with comprehensive 
                technology solutions and digital services.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Leadership Team Section -->
    <section class="section-padding bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Leadership Team</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Meet the experienced professionals leading our mission to transform businesses through technology
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-green-50 to-green-100 card-hover">
            <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-green-600 to-emerald-600 flex items-center justify-center shadow-professional">
              <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-3 text-gray-800">CEO & Founder</h3>
            <p class="text-gray-600 leading-relaxed">
              Leading Hassel's strategic vision and operations across all technology domains
            </p>
          </div>
          <div class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-emerald-50 to-emerald-100 card-hover">
            <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-emerald-600 to-green-600 flex items-center justify-center shadow-professional">
              <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-3 text-gray-800">CTO</h3>
            <p class="text-gray-600 leading-relaxed">
              Overseeing technical strategy and innovation for maximum client impact
            </p>
          </div>
          <div class="text-center p-8 rounded-professional-lg bg-gradient-to-br from-yellow-50 to-yellow-100 card-hover">
            <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center shadow-professional">
              <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-3 text-gray-800">COO</h3>
            <p class="text-gray-600 leading-relaxed">
              Managing operations and client success to ensure sustainable growth
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Values Section -->
    <section class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg mb-4">Our Core Values</h2>
          <p class="text-xl text-green-100 max-w-3xl mx-auto">
            The principles that guide everything we do and shape our company culture
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4">Integrity</h3>
            <p class="text-green-100">
              We maintain the highest ethical standards in all our business practices
            </p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4">Innovation</h3>
            <p class="text-green-100">
              We continuously push boundaries to deliver cutting-edge solutions
            </p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4">Excellence</h3>
            <p class="text-green-100">
              We strive for the highest quality in everything we deliver
            </p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4">Collaboration</h3>
            <p class="text-green-100">
              We work together with clients and partners to achieve shared success
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="section-padding bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Our Impact in Numbers</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Measurable results that demonstrate our commitment to client success
          </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">500+</div>
            <div class="text-gray-600">Projects Completed</div>
          </div>
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">98%</div>
            <div class="text-gray-600">Client Satisfaction</div>
          </div>
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">50+</div>
            <div class="text-gray-600">Team Members</div>
          </div>
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">10+</div>
            <div class="text-gray-600">Years Experience</div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="heading-lg mb-6">Ready to Work With Us?</h2>
        <p class="text-xl text-green-100 mb-8">
          Let's discuss how we can help transform your business with our technology solutions.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <router-link to="/contact" class="btn btn-cta text-lg px-8 py-4">
            Get In Touch
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
          </router-link>
          <router-link to="/our-work" class="btn border-2 border-white text-white hover:bg-white hover:text-green-600 text-lg px-8 py-4">
            View Our Work
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
// No additional script needed for this component
</script>
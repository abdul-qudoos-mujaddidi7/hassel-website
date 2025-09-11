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
            Our <span class="gradient-text">Work</span>
          </h1>
          <p class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto animate-fadeInUp" style="animation-delay: 0.2s">
            Discover our comprehensive technology solutions and services designed to empower businesses
          </p>
        </div>
      </div>
    </section>

    <!-- Thematic Areas Section -->
    <section class="section-padding bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Our Service Areas</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Specialized expertise across key technology domains that drive modern business success
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div class="p-8 rounded-professional-lg border border-gray-200 card-hover">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Digital Transformation</h3>
            <p class="text-gray-600 mb-6">
              Modernize your business processes with cutting-edge digital solutions that drive efficiency and growth.
            </p>
            <ul class="text-sm text-gray-600 space-y-2">
              <li>• Process automation</li>
              <li>• Legacy system modernization</li>
              <li>• Digital workflow optimization</li>
              <li>• Change management support</li>
            </ul>
          </div>

          <div class="p-8 rounded-professional-lg border border-gray-200 card-hover">
            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-6">
              <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Cloud Solutions</h3>
            <p class="text-gray-600 mb-6">
              Scalable, secure, and cost-effective cloud infrastructure that grows with your business needs.
            </p>
            <ul class="text-sm text-gray-600 space-y-2">
              <li>• Cloud migration</li>
              <li>• Infrastructure as a Service</li>
              <li>• Cloud security</li>
              <li>• Multi-cloud strategies</li>
            </ul>
          </div>

          <div class="p-8 rounded-professional-lg border border-gray-200 card-hover">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-6">
              <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Data Analytics</h3>
            <p class="text-gray-600 mb-6">
              Transform raw data into actionable insights that drive informed business decisions and growth.
            </p>
            <ul class="text-sm text-gray-600 space-y-2">
              <li>• Business intelligence</li>
              <li>• Predictive analytics</li>
              <li>• Data visualization</li>
              <li>• Machine learning</li>
            </ul>
          </div>

          <div class="p-8 rounded-professional-lg border border-gray-200 card-hover">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Cybersecurity</h3>
            <p class="text-gray-600 mb-6">
              Protect your digital assets with comprehensive security solutions and best practices.
            </p>
            <ul class="text-sm text-gray-600 space-y-2">
              <li>• Security assessments</li>
              <li>• Threat monitoring</li>
              <li>• Compliance management</li>
              <li>• Incident response</li>
            </ul>
          </div>

          <div class="p-8 rounded-professional-lg border border-gray-200 card-hover">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Mobile Development</h3>
            <p class="text-gray-600 mb-6">
              Native and cross-platform mobile applications that deliver exceptional user experiences.
            </p>
            <ul class="text-sm text-gray-600 space-y-2">
              <li>• iOS development</li>
              <li>• Android development</li>
              <li>• Cross-platform apps</li>
              <li>• App store optimization</li>
            </ul>
          </div>

          <div class="p-8 rounded-professional-lg border border-gray-200 card-hover">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-6">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Growth Strategy</h3>
            <p class="text-gray-600 mb-6">
              Strategic consulting and implementation to accelerate your business growth and market presence.
            </p>
            <ul class="text-sm text-gray-600 space-y-2">
              <li>• Market analysis</li>
              <li>• Technology roadmaps</li>
              <li>• Performance optimization</li>
              <li>• Scalability planning</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Technology Solutions Section -->
    <section class="section-padding bg-gradient-bg-organic">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Technology Solutions</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Comprehensive technology services tailored to meet your specific business needs
          </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
          <div class="space-y-8">
            <div class="p-8 rounded-professional-lg bg-white card-hover">
              <h3 class="text-2xl font-semibold gradient-text mb-4">Custom Development</h3>
              <div class="space-y-4">
                <div class="flex items-start gap-3">
                  <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  <div>
                    <h4 class="font-semibold">Web Applications</h4>
                    <p class="text-sm text-gray-600">
                      Modern, responsive web applications built with cutting-edge technologies
                    </p>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  <div>
                    <h4 class="font-semibold">API Development</h4>
                    <p class="text-sm text-gray-600">
                      Robust APIs that integrate seamlessly with your existing systems
                    </p>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  <div>
                    <h4 class="font-semibold">Database Design</h4>
                    <p class="text-sm text-gray-600">
                      Scalable database architectures optimized for performance and security
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="space-y-8">
            <div class="p-8 rounded-professional-lg bg-white card-hover">
              <h3 class="text-2xl font-semibold gradient-text mb-4">Consulting Services</h3>
              <div class="space-y-4">
                <div class="flex items-start gap-3">
                  <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  <div>
                    <h4 class="font-semibold">Technology Strategy</h4>
                    <p class="text-sm text-gray-600">
                      Strategic planning and roadmaps for technology adoption and growth
                    </p>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  <div>
                    <h4 class="font-semibold">System Integration</h4>
                    <p class="text-sm text-gray-600">
                      Seamless integration of new and existing systems for optimal performance
                    </p>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  <div>
                    <h4 class="font-semibold">Performance Optimization</h4>
                    <p class="text-sm text-gray-600">
                      Enhance system performance and efficiency through expert optimization
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Project Showcase Section -->
    <section class="section-padding bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg text-gray-900 mb-4">Featured Projects</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            A showcase of our recent work and the impact we've created for our clients
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div class="relative group rounded-professional-lg overflow-hidden card-hover">
            <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-green-500 to-green-600">
              <div class="flex items-center justify-center text-white">
                <div class="text-center">
                  <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                  </svg>
                  <h3 class="text-xl font-bold">E-Commerce Platform</h3>
                </div>
              </div>
            </div>
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300 flex items-center justify-center">
              <div class="text-white text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <h3 class="text-xl font-bold mb-2">E-Commerce Platform</h3>
                <p class="text-sm">Modern online store solution</p>
              </div>
            </div>
          </div>

          <div class="relative group rounded-professional-lg overflow-hidden card-hover">
            <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-emerald-500 to-emerald-600">
              <div class="flex items-center justify-center text-white">
                <div class="text-center">
                  <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                  </svg>
                  <h3 class="text-xl font-bold">Analytics Dashboard</h3>
                </div>
              </div>
            </div>
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300 flex items-center justify-center">
              <div class="text-white text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <h3 class="text-xl font-bold mb-2">Analytics Dashboard</h3>
                <p class="text-sm">Real-time business intelligence</p>
              </div>
            </div>
          </div>

          <div class="relative group rounded-professional-lg overflow-hidden card-hover">
            <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-yellow-500 to-orange-500">
              <div class="flex items-center justify-center text-white">
                <div class="text-center">
                  <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                  </svg>
                  <h3 class="text-xl font-bold">Mobile App</h3>
                </div>
              </div>
            </div>
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300 flex items-center justify-center">
              <div class="text-white text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <h3 class="text-xl font-bold mb-2">Mobile App</h3>
                <p class="text-sm">Cross-platform mobile solution</p>
              </div>
            </div>
          </div>
        </div>

        <div class="text-center mt-12">
          <router-link to="/contact" class="btn btn-cta text-lg px-8 py-4">
            Start Your Project
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- Impact Stats Section -->
    <section class="section-padding bg-gradient-to-r from-green-600 to-emerald-600 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="heading-lg mb-4">Our Impact</h2>
          <p class="text-xl text-green-100 max-w-3xl mx-auto">
            Measurable results that demonstrate our commitment to client success
          </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-bold mb-2">500+</div>
            <div class="text-green-100">Projects Completed</div>
          </div>
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-bold mb-2">98%</div>
            <div class="text-green-100">Client Satisfaction</div>
          </div>
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-bold mb-2">50+</div>
            <div class="text-green-100">Team Members</div>
          </div>
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-bold mb-2">10+</div>
            <div class="text-green-100">Years Experience</div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding bg-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="heading-lg text-gray-900 mb-6">Ready to Transform Your Business?</h2>
        <p class="text-xl text-gray-600 mb-8">
          Let's discuss how we can help you achieve your goals with our technology solutions and expertise.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <router-link to="/contact" class="btn btn-cta text-lg px-8 py-4">
            Start Your Project
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
          </router-link>
          <router-link to="/about" class="btn btn-secondary text-lg px-8 py-4">
            Learn More About Us
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
// No additional script needed for this component
</script>
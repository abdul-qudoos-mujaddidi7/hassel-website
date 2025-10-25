<template>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    RTL/LTR Test Page
                </h1>
                <p class="text-lg text-gray-600">
                    Test the RTL and LTR functionality of your website
                </p>
            </div>

            <!-- Language Switcher -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Language Switcher</h2>
                <div class="flex justify-center">
                    <LanguageSwitcher />
                </div>
            </div>

            <!-- Current Language Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Current Language Info</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>Current Language:</strong> {{ currentLanguage }}</p>
                        <p><strong>Language Code:</strong> {{ languageCode }}</p>
                        <p><strong>Is RTL:</strong> {{ isRTL ? 'Yes' : 'No' }}</p>
                        <p><strong>Text Direction:</strong> {{ textDirection }}</p>
                    </div>
                    <div>
                        <p><strong>Text Alignment:</strong> {{ textAlign }}</p>
                        <p><strong>Flex Direction:</strong> {{ flexDirection }}</p>
                        <p><strong>Dropdown Position:</strong> {{ dropdownPosition }}</p>
                        <p><strong>Arrow Direction:</strong> {{ arrowDirection }}</p>
                    </div>
                </div>
            </div>

            <!-- Text Samples -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Text Samples</h2>
                
                <!-- English Text -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-2">English Text (LTR)</h3>
                    <p class="text-gray-700">
                        This is a sample English text that should be displayed from left to right. 
                        The text should flow naturally and be easy to read in the LTR direction.
                    </p>
                </div>

                <!-- Farsi Text -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-2">Farsi Text (RTL)</h3>
                    <p class="text-gray-700 rtl-text">
                        این یک متن نمونه فارسی است که باید از راست به چپ نمایش داده شود. 
                        متن باید به طور طبیعی جریان یابد و در جهت RTL به راحتی خوانده شود.
                    </p>
                </div>

                <!-- Pashto Text -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-2">Pashto Text (RTL)</h3>
                    <p class="text-gray-700 rtl-text">
                        دا د پښتو ژبې یو نمونه متن دی چې باید له ښي څخه کیڼ ته وښودل شي. 
                        متن باید په طبیعي ډول جریان ومومي او په RTL لوری کې اسانه لوستل شي.
                    </p>
                </div>
            </div>

            <!-- Layout Examples -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Layout Examples</h2>
                
                <!-- Card Layout -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gray-100 rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Card 1</h3>
                        <p class="text-sm text-gray-600">This is a sample card with some content.</p>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Card 2</h3>
                        <p class="text-sm text-gray-600">Another card with different content.</p>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Card 3</h3>
                        <p class="text-sm text-gray-600">Third card to complete the grid.</p>
                    </div>
                </div>

                <!-- Button Examples -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <button class="btn btn-primary">Primary Button</button>
                    <button class="btn btn-secondary">Secondary Button</button>
                    <button class="btn btn-accent">Accent Button</button>
                </div>

                <!-- Form Example -->
                <div class="max-w-md">
                    <h3 class="text-lg font-medium mb-4">Form Example</h3>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Name
                            </label>
                            <input 
                                type="text" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Enter your name"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input 
                                type="email" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Enter your email"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Message
                            </label>
                            <textarea 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                rows="3"
                                placeholder="Enter your message"
                            ></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full">
                            Submit
                        </button>
                    </form>
                </div>
            </div>

            <!-- Navigation Example -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Navigation Example</h2>
                <nav class="flex space-x-4">
                    <a href="#" class="text-green-600 hover:text-green-800 font-medium">Home</a>
                    <a href="#" class="text-gray-600 hover:text-gray-800 font-medium">About</a>
                    <a href="#" class="text-gray-600 hover:text-gray-800 font-medium">Services</a>
                    <a href="#" class="text-gray-600 hover:text-gray-800 font-medium">Contact</a>
                </nav>
            </div>

            <!-- List Example -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">List Example</h2>
                <ul class="space-y-2">
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        First item in the list
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        Second item in the list
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        Third item in the list
                    </li>
                </ul>
            </div>

            <!-- Table Example -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Table Example</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    John Doe
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    john@example.com
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Admin
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Jane Smith
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    jane@example.com
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    User
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-blue-900 mb-4">Instructions</h2>
                <div class="text-blue-800 space-y-2">
                    <p>1. Use the language switcher above to change between English, Farsi, and Pashto</p>
                    <p>2. Observe how the layout changes when switching between LTR (English) and RTL (Farsi/Pashto)</p>
                    <p>3. Check that text alignment, margins, padding, and other layout properties adjust correctly</p>
                    <p>4. Verify that forms, tables, navigation, and other components work properly in both directions</p>
                    <p>5. Test on different screen sizes to ensure responsive behavior</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useI18n } from '../composables/useI18n.js';
import { useRTL } from '../composables/useRTL.js';
import LanguageSwitcher from '../components/LanguageSwitcher.vue';

const { currentLanguage, isRTL } = useI18n();
const { 
    languageCode, 
    textAlign, 
    textDirection, 
    flexDirection, 
    dropdownPosition, 
    arrowDirection 
} = useRTL();
</script>









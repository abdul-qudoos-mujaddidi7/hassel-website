<template>
  <div class="space-y-6">
    <!-- Stats Cards Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Profit Card -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
              <i class="text-2xl text-blue-600">📈</i>
            </div>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Profit</p>
            <p class="text-2xl font-semibold text-gray-900">17392.83</p>
          </div>
        </div>
      </div>

      <!-- Expense Card -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
              <i class="text-2xl text-yellow-600">💰</i>
            </div>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Expense</p>
            <p class="text-2xl font-semibold text-gray-900">13090.17</p>
          </div>
        </div>
      </div>

      <!-- Sales Card -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
              <i class="text-2xl text-purple-600">🛒</i>
            </div>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Sales</p>
            <p class="text-2xl font-semibold text-gray-900">30483.00</p>
          </div>
        </div>
      </div>

      <!-- Patients Card -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
              <i class="text-2xl text-gray-600">👥</i>
            </div>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Patients</p>
            <p class="text-2xl font-semibold text-gray-900">2</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Income vs Expense Chart -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">This Year Income Vs Expense</h3>
        <div class="h-64 flex items-end justify-between space-x-2">
          <!-- Chart bars would go here -->
          <div class="flex-1 bg-gray-200 rounded-t h-32 flex items-end">
            <div class="w-full bg-blue-600 rounded-t h-24"></div>
          </div>
          <div class="flex-1 bg-gray-200 rounded-t h-8 flex items-end">
            <div class="w-full bg-gray-400 rounded-t h-4"></div>
          </div>
          <div class="flex-1 bg-gray-200 rounded-t h-16 flex items-end">
            <div class="w-full bg-blue-600 rounded-t h-12"></div>
          </div>
          <div class="flex-1 bg-gray-200 rounded-t h-20 flex items-end">
            <div class="w-full bg-blue-600 rounded-t h-16"></div>
          </div>
          <div class="flex-1 bg-gray-200 rounded-t h-32 flex items-end">
            <div class="w-full bg-blue-600 rounded-t h-24"></div>
          </div>
        </div>
        <div class="flex justify-center mt-4 space-x-4">
          <div class="flex items-center">
            <div class="w-3 h-3 bg-gray-400 rounded mr-2"></div>
            <span class="text-sm text-gray-600">Income</span>
          </div>
          <div class="flex items-center">
            <div class="w-3 h-3 bg-blue-600 rounded mr-2"></div>
            <span class="text-sm text-gray-600">Expenses</span>
          </div>
        </div>
      </div>

      <!-- Profit Chart -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Profit: 17392.83</h3>
        <div class="h-64 flex items-center justify-center">
          <div class="text-center">
            <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mb-4">
              <i class="text-4xl text-gray-400">📊</i>
            </div>
            <p class="text-gray-500">Chart visualization would go here</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Expenses Breakdown -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium text-gray-900">AFG 13090.17 Expenses Based on Amount and Percentage</h3>
          <div class="flex space-x-2">
            <button class="px-3 py-1 bg-blue-600 text-white text-xs rounded-full">THIS YEAR</button>
            <button class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">THIS MONTH</button>
            <button class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">TODAY</button>
          </div>
        </div>
        
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-900">Isabell Goodwin(AFG 321.00)</p>
              <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 2.45%"></div>
              </div>
            </div>
            <span class="text-sm text-gray-500 ml-4">2.45%</span>
          </div>
          
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-900">Pearline Wyman (AFG 123.00)</p>
              <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 0.94%"></div>
              </div>
            </div>
            <span class="text-sm text-gray-500 ml-4">0.94%</span>
          </div>
          
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-900">Prof. Iliana Price MD (AFG 21.00)</p>
              <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 0.16%"></div>
              </div>
            </div>
            <span class="text-sm text-gray-500 ml-4">0.16%</span>
          </div>
        </div>
      </div>

      <!-- Upcoming Appointments -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Appointment</h3>
        
        <div class="overflow-hidden">
          <table class="min-w-full">
            <thead class="bg-blue-50">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr>
                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Jackson Silva</td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">19:28:00</td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">+1 (505) 276-6676</td>
              </tr>
              <tr class="bg-gray-50">
                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Winifred Warren</td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">23:03:00</td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">+1 (832) 937-1216</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAuthRepository } from '../../stores/Auth.js';

const authStore = useAuthRepository();

onMounted(() => {
  // Load dashboard data
  console.log('Dashboard loaded');
});
</script>
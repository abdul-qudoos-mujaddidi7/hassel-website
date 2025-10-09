<template>
   <Header :pageTitle='$t("dashboard")' />
  <div class="space-y-8">
    <!-- KPIs: clean, square cards with left accent bar -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div v-for="k in kpis" :key="k.label" class="bg-white border border-gray-200 p-5 relative">
        <div class="absolute left-0 top-0 h-full w-1 bg-emerald-600"></div>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-gray-100 flex items-center justify-center text-gray-600">
            <v-icon size="22">{{ k.icon }}</v-icon>
          </div>
          <div>
            <p class="text-sm text-gray-500">{{ k.label }}</p>
            <p class="text-2xl font-semibold text-gray-900">{{ k.value ?? '—' }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Content lists only (no charts) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="bg-white border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
          <h3 class="text-base font-semibold text-gray-900">Latest News</h3>
          <a href="/admin/news" class="text-sm text-emerald-700 hover:underline">View all</a>
        </div>
        <div class="p-5 max-h-96 overflow-y-auto pr-1">
          <div v-for="n in latest.news" :key="n.id" class="py-2 flex items-center justify-between border-b border-gray-100 last:border-0">
            <span class="text-gray-900 font-medium truncate">{{ n.title }}</span>
            <span class="text-sm text-gray-500 ml-4 whitespace-nowrap">{{ formatDate(n.published_date || n.published_at) }}</span>
          </div>
        </div>
      </div>
      <div class="space-y-6">
        <div class="bg-white border border-gray-200">
          <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-900">Latest Publications</h3>
            <a href="/admin/publications" class="text-sm text-emerald-700 hover:underline">View all</a>
          </div>
          <div class="p-5 max-h-44 overflow-y-auto pr-1">
            <div v-for="p in latest.publications" :key="p.id" class="py-2 flex items-center justify-between border-b border-gray-100 last:border-0">
              <span class="text-gray-900 font-medium truncate">{{ p.title }}</span>
              <span class="text-sm text-gray-500 ml-4 whitespace-nowrap">{{ (p.file_type && p.file_type.toUpperCase) ? p.file_type.toUpperCase() : '—' }}</span>
            </div>
          </div>
        </div>
        <div class="bg-white border border-gray-200">
          <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-900">Latest Success Stories</h3>
            <a href="/admin/success-stories" class="text-sm text-emerald-700 hover:underline">View all</a>
          </div>
          <div class="p-5 max-h-44 overflow-y-auto pr-1">
            <div v-for="s in latest.successStories" :key="s.id" class="py-2 flex items-center justify-between border-b border-gray-100 last:border-0">
              <span class="text-gray-900 font-medium truncate">{{ s.title }}</span>
              <span class="text-sm text-gray-500 ml-4 whitespace-nowrap">{{ formatDate(s.published_date || s.published_at) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import axios from '../../../axios.js';
import Header from '../components/Header.vue';

const stats = reactive({
  news: { total: 0, published: 0, draft: 0 },
  publications: { total: 0, published: 0, draft: 0 },
  successStories: { total: 0, published: 0 },
  training: { total: 0, active: 0 },
});

const latest = reactive({ news: [], publications: [], successStories: [] });

// Removed charts; keep lightweight lists only

function formatDate(d) {
  if (!d) return '—';
  try {
    const dt = new Date(d);
    return dt.toLocaleDateString();
  } catch { return d; }
}

async function fetchAdminStats() {
  try {
    const { data } = await axios.get('dashboard/stats');
    const s = data?.data || {};
    stats.news.total = s.news?.total ?? stats.news.total;
    stats.news.published = s.news?.published ?? stats.news.published;
    stats.news.draft = s.news?.draft ?? stats.news.draft;
    stats.publications.total = s.publications?.total ?? stats.publications.total;
    stats.publications.published = s.publications?.published ?? stats.publications.published;
    stats.publications.draft = s.publications?.draft ?? stats.publications.draft;
    stats.successStories.total = s.success_stories?.total ?? stats.successStories.total;
    stats.successStories.published = s.success_stories?.published ?? stats.successStories.published;
    stats.training.total = s.training_programs?.total ?? stats.training.total;
    stats.training.active = s.training_programs?.active ?? stats.training.active;
  } catch (_) {
    // Fallback: compute counts using public endpoints meta.total
    try {
      const [n, p, s, t] = await Promise.all([
        axios.get('/api/news?per_page=1'),
        axios.get('/api/publications?per_page=1'),
        axios.get('/api/success-stories?per_page=1'),
        axios.get('/api/training-programs?per_page=1'),
      ]);
      stats.news.total = n?.data?.meta?.total ?? 0;
      stats.publications.total = p?.data?.meta?.total ?? 0;
      stats.successStories.total = s?.data?.meta?.total ?? 0;
      stats.training.total = t?.data?.meta?.total ?? 0;
    } catch {}
  }
}

async function fetchLatest() {
  try {
    const [n, p, s] = await Promise.all([
      axios.get('/api/news?per_page=5'),
      axios.get('/api/publications?per_page=5'),
      axios.get('/api/success-stories?per_page=5'),
    ]);
    latest.news = n?.data?.data || n?.data || [];
    latest.publications = p?.data?.data || p?.data || [];
    latest.successStories = s?.data?.data || s?.data || [];
  } catch (e) {
    console.error('Failed to load latest content', e);
  }
}

onMounted(async () => {
  await Promise.all([fetchAdminStats(), fetchLatest()]);
});
// UI computed helpers
const kpis = computed(() => [
  { icon: 'mdi-newspaper-variant-outline', label: 'News (published)', value: stats.news.published },
  { icon: 'mdi-book-outline', label: 'Publications (published)', value: stats.publications.published },
  { icon: 'mdi-trophy-outline', label: 'Success Stories (published)', value: stats.successStories.published },
  { icon: 'mdi-school-outline', label: 'Training (active)', value: stats.training.active },
]);

const newsTotal = computed(() => Math.max((stats.news.published || 0) + (stats.news.draft || 0), 1));
const newsPubWidth = computed(() => `${Math.round(((stats.news.published || 0) / newsTotal.value) * 100)}%`);
const newsDraftWidth = computed(() => `${Math.round(((stats.news.draft || 0) / newsTotal.value) * 100)}%`);

const pubTotal = computed(() => Math.max((stats.publications.published || 0) + (stats.publications.draft || 0), 1));
const pubPubWidth = computed(() => `${Math.round(((stats.publications.published || 0) / pubTotal.value) * 100)}%`);
const pubDraftWidth = computed(() => `${Math.round(((stats.publications.draft || 0) / pubTotal.value) * 100)}%`);
</script>
<template>
	<div class="topbar">
		<div class="left">
			<v-btn icon="mdi-information-outline" variant="text" density="comfortable"></v-btn>
		</div>
		<div class="center">
			<v-text-field
				variant="solo"
				density="comfortable"
				flat
				hide-details
				prepend-inner-icon="mdi-magnify"
				:placeholder="$t('search') + '...'"
				class="search"
			></v-text-field>
		</div>
		<div class="right">
			<v-btn icon="mdi-tune" variant="text" density="comfortable"></v-btn>
			<v-btn icon="mdi-bell-outline" variant="text" density="comfortable"></v-btn>
		</div>
	</div>
</template>

<script setup>
// Pure presentational top bar
</script>

<style scoped>
.topbar {
	display: grid;
	grid-template-columns: 48px 1fr auto;
	align-items: center;
	gap: 8px;
	height: 60px;
	padding: 0 12px;
	background: #ffffff;
}

.search :deep(.v-field) { 
	border-radius: 9999px; 
}

.search :deep(.v-field__overlay) { background: #f8fafc; }
.search :deep(input) { font-weight: 500; }

.right { display: flex; gap: 4px; }
</style>



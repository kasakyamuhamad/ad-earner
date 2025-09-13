<template>
  <div class="flex items-center space-x-1">
    <template v-for="(link, index) in links" :key="`link-${index}`">
      <Link
        v-if="link.url"
        :key="`link-${index}`"
        :href="link.url"
        class="px-3 py-1 border rounded hover:bg-gray-100"
        v-html="link.label"
      />
      <span
        v-else
        :key="`disabled-${index}`"
        class="px-3 py-1 border rounded text-gray-400"
        v-html="link.label"
      />
    </template>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  links: Array
})
</script>

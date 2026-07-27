import { reactive, computed, watch } from 'vue'
import { router } from '@inertiajs/vue3'

/**
 * Drives a filter form that auto-submits (debounced) on any change, and
 * exposes the currently active filters as removable chips.
 *
 * @param {string} routeName
 * @param {Object} initial - initial/empty values for each filter field
 * @param {Object} fields - per-field config: { label, empty, display, resolve }
 *   - label: string | () => string
 *   - empty: the "unset" value for this field (default '')
 *   - display: (value) => displayValue, for sync formatting
 *   - resolve: async (value) => displayValue, for values needing a lookup (e.g. a code -> name)
 */
export function useAutoFilters(routeName, initial, fields, requestOptions = {}) {
  const filterForm = reactive({ ...initial })
  const resolved = reactive({})

  const submit = () => {
    router.get(route(routeName), filterForm, {
      preserveState: true,
      preserveScroll: true,
      ...requestOptions,
    })
  }

  let debounce = null
  watch(filterForm, () => {
    clearTimeout(debounce)
    debounce = setTimeout(submit, 400)
  }, { deep: true })

  for (const [key, config] of Object.entries(fields)) {
    if (config.resolve) {
      watch(() => filterForm[key], async (value) => {
        resolved[key] = value ? await config.resolve(value) : null
      }, { immediate: true })
    }
  }

  const isEmpty = (key, config) => {
    const empty = 'empty' in config ? config.empty : ''
    return filterForm[key] === empty || filterForm[key] === null || filterForm[key] === undefined
  }

  const activeFilters = computed(() => Object.entries(fields)
    .filter(([key, config]) => !isEmpty(key, config))
    .map(([key, config]) => ({
      key,
      label: typeof config.label === 'function' ? config.label() : config.label,
      value: config.resolve
        ? (resolved[key] ?? filterForm[key])
        : (config.display ? config.display(filterForm[key]) : filterForm[key]),
      onRemove: () => { filterForm[key] = 'empty' in config ? config.empty : '' },
    })))

  return { filterForm, activeFilters, submit }
}

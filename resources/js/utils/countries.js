let cache = null

export async function loadCountries() {
  if (!cache) {
    const res = await fetch('/dashboard-assets/js/countries.json')
    cache = Object.values(await res.json())
  }
  return cache
}

export async function countryName(value) {
  if (!value) return null
  const countries = await loadCountries()
  const country = countries.find(c => Number(c.data_val) === Number(value))
  return country ? country.cname : null
}

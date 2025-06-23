type Flight = {
  flight_id: number
  flightno: string
  from: number
  to: number
  departure: string
  arrival: string
  airline_id: number
  airplane_id: number
}

export const useFlights = () => {
  const flights = useState<Flight[]>('flights', () => [
    {
      flight_id: 1,
      flightno: 'AA123',
      from: 1,
      to: 2,
      departure: '2023-10-20T09:00',
      arrival: '2023-10-20T12:30',
      airline_id: 1,
      airplane_id: 1
    }
  ])

  async function addFlight(flight: Omit<Flight, 'flight_id'>) {
  const config = useRuntimeConfig()
  const savedFlight = await $fetch<Flight>('/api/flights', {
    method: 'POST',
    baseURL: config.public.apiBase,
    body: flight
  })

  flights.value.push(savedFlight)
}

  function updateFlight(id: number, updated: Partial<Flight>) {
    const index = flights.value.findIndex(f => f.flight_id === id)
    if (index !== -1) flights.value[index] = { ...flights.value[index], ...updated }
  }

  function deleteFlight(id: number) {
    flights.value = flights.value.filter(f => f.flight_id !== id)
  }

  function getFlight(id: number) {
    return flights.value.find(f => f.flight_id === id)
  }

  return { flights, addFlight, updateFlight, deleteFlight, getFlight }
}

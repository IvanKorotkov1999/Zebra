export interface Health {
  status: string
  php: string
  db: string
}

export async function fetchHealth(): Promise<Health> {
  const response = await fetch('/api/health')
  if (!response.ok) {
    throw new Error(`API responded with ${response.status}`)
  }
  return response.json()
}

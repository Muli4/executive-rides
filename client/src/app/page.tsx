import Link from "next/link";

export default function Home() {
  return (
    <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100">
      {/* Hero Section */}
      <h1 className="text-4xl font-bold text-center text-gray-800">
        Find Your Perfect Ride & Stay
      </h1>
      <p className="text-lg text-gray-600 mt-4">
        Browse and book luxury cars and comfortable stays with ease.
      </p>

      {/* Search Bar */}
      <div className="mt-6 flex space-x-2">
        <input
          type="text"
          placeholder="Search Cars or BnBs..."
          className="px-4 py-2 border rounded-lg w-64 focus:outline-none"
        />
        <button className="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
          Search
        </button>
      </div>

      {/* Links to Listings */}
      <div className="mt-6">
        <Link href="/listings">
          <button className="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600">
            Browse Listings
          </button>
        </Link>
      </div>
    </div>
  );
}

import link from 'next/link';

export default function Navbar(){
    return(
        <nav className="p-4 bg-blue-500 text-white flex justify-between">
             <h1 className="text-xl font-bold">Executive Rides & Stays</h1>
             <div>
                <Link href ="/" className='mr-4'>Home</Link>
                <Link href="/listings" className="mr-4">Listings</Link>
                <Link href="/login">Login</Link>
             </div>
         </nav>
    );
}
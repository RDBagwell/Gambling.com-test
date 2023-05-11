import { Head } from '@inertiajs/react';
import { useCallback, useEffect, useState } from 'react';

import SecondaryButton from '@/components/SecondaryButton';
import AffilliateList from '@/components/List';

export default function Welcome() {
    const [list, setList] = useState([]);
    const url = "http://localhost:8000/api/affiliates";
    const entries = Object.entries(list);
    
    const fetchData = useCallback(async () => {
        const res = await fetch(url);
        const data = await res.json();
        setList(data);
      }, []);

    useEffect(()=>{
        fetchData().catch((err) => console.error(err));
    },[]);

    const handleSubmit = async (e) =>{
        e.preventDefault();
        const file = e.target[0].files[0];
        if(!file) return;
        const formData = new FormData();
        formData.append('file', file);
        await fetch(url,{
            method: 'POST',
            body: formData
        });
        await fetchData();
        e.target[0].value = ""
    }

    return (
        <>
            <Head title="My App" />
            <div className="flex justify-center mt-32 px-3">
                <div className="flex-col justify-center">
                    <div className="text-center text-xl font-bold mb-3">Upload File</div>
                    <form onSubmit={handleSubmit}>
                        <input className="border" type="file" name='file'/>
                        <SecondaryButton type='submit' >Upload File</SecondaryButton>
                    </form>
                    {entries.length > 0 && 
                        <div className="my-3">
                            <h1 className="text-center mb-2 font-bold text-xl">Affiliates within 100km of Dublin office.</h1>
                            <div className='flex'>
                                <div className='flex-1 border border-black p-2'>Affiliate ID</div>
                                <div className='flex-1 border border-black p-2'>Name</div>
                            </div>
                            <AffilliateList entries={entries} />
                        </div>
                    }

                </div>
            </div>
        </>
    );
}

import React from 'react'

function ListCard({affiliate_id, name}) {
  return (
    <div className="flex even:bg-slate-200">
        <div className="flex-1 border border-black p-2">
            <div>{affiliate_id}</div> 
        </div>
        <div className="flex-1 border border-black p-2">
            <div>{name}</div> 
        </div>
    </div>
  )
}

export default ListCard
import React from 'react'
import ListCard from './cards/listCard';

function List({ entries }) {
   return entries.map((listItem)=>{
        const affiliate_id = listItem[1].affiliate_id;
        const name = listItem[1].name;
        return (
            <ListCard
            key={affiliate_id} 
            affiliate_id = {affiliate_id}
            name = {name} 
            />
          )
    })
}

export default List
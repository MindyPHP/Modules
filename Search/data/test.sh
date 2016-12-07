#!/bin/sh

i=0
function deleteIndex
{
   i=0
   curl -XDELETE 'http://localhost:9200/search' && echo
}

function createIndex
{
   body=`cat index.json`
   curl -XPUT 'http://localhost:9200/search' -d "$body" && echo
}

function createMapping
{
   curl -XPUT 'http://localhost:9200/search/zakaz-product/_mapping' -d '{
      "zakaz-product": {
         "_all" : {"analyzer" : "my_analyzer"},
         "properties" : {
            "body" : { "type" : "string", "analyzer" : "my_analyzer" }
         }
      }
   }' && echo
}

function indexDocument
{
   i=$((i+1))
   curl -XPUT "http://localhost:9200/search/zakaz-product/$i" -d "{\"body\": \"$1\"}" && echo
}

function indexRefresh
{
   curl -XPOST 'http://localhost:9200/search/_refresh' && echo
}

deleteIndex
createIndex
createMapping

indexDocument "Булочки венские под клюквенным соусом с салатом"
indexDocument "Салат из апельсинов с клюквой и морковью"
indexDocument "Килограмм клюквы мороженой"
indexDocument "Клюквенное мороженое вятское"
indexDocument "Мармелад глазов Клюквенный"
indexDocument "Настойка c клюквой"
indexDocument "Мороженный"
indexDocument "Цветы"

indexRefresh

echo

function search
{
    out=$(curl -s 'http://localhost:9200/search/zakaz-product/_search?pretty=true' -d "{
        \"query\": {
            \"query_string\": {
                \"query\": \"$1\"
            }
        },
        \"fields\": [\"_id\"]
    }" | grep "_id" | tr -d ' ' | sed 's/"_id":"//g' | sed 's/",//g' | tr '\n' ' ')
    printf "Should return $2: $out"
    echo
}

search "клюква" "6 2 1 4 5 3"
search "Булочки" "1"
search "салат" "1 2"
search "мороженое" "7 4 3"
search "клюквенным" "6 2 1 4 5 3"
search "марковью" "(пусто)"
search "цветок" "8"

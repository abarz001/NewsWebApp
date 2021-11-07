sudo mkdir keywords
COUNTER=1
readarray -d '' files < <(printf '%s\0' /var/www/html/files/fake_news_* | sort -zV)
for file in "${files[@]}";
do
textrank -t $file -s 1 -w 5 > ./keywords/keywords_for_$COUNTER.txt
let COUNTER++
done

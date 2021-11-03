COUNTER=1
for file in /var/www/html/files/fake_news_*
do
textrank -t $file -s 1 -w 5 > keywords_for_$COUNTER.txt
let COUNTER++
done

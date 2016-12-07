

## Настройка ElasticSearch

Установить плагины:

Russian morphology отсюда: [elasticsearch-analysis-morphology](https://github.com/imotov/elasticsearch-analysis-morphology)
elasticsearch-HQ отсюда: [elastichq](http://www.elastichq.org/support_plugin.html)

В директории ElasticSearch выполнить:

```
bin/plugin -install analysis-morphology -url http://dl.bintray.com/content/imotov/elasticsearch-plugins/org/elasticsearch/elasticsearch-analysis-morphology/1.2.0/elasticsearch-analysis-morphology-1.2.0.zip
bin/plugin -install royrusso/elasticsearch-HQ
```

Перезапустить ElasticSearch

### elasticsearch.yml

```yaml
index:
  number_of_shards: 1
  number_of_replicas: 0  # not for production

  analysis:
    char_filter:
      ru:
        type: mapping
        mappings: ['Ё=>Е', 'ё=>е']
    analyzer:
      index_ru:
        type: custom
        tokenizer: standard
        filter: [custom_word_delimiter, lowercase, russian_morphology, english_morphology, stopwords_ru, stop]
        char_filter: [ru]
      search_ru:
        type: custom
        tokenizer: standard
        filter: [custom_word_delimiter, lowercase, russian_morphology, english_morphology, stopwords_ru, stop]
        char_filter: [ru]
    filter:
      stopwords_ru:
        type: stop
        stopwords: [а,без,более,бы,был,была,были,было,быть,в,вам,вас,весь,во,вот,все,всего,всех,вы,где,да,даже,для,до,его,ее,если,есть,еще,же,за,здесь,и,из,или,им,их,к,как,ко,когда,кто,ли,либо,мне,может,мы,на,надо,наш,не,него,нее,нет,ни,них,но,ну,о,об,однако,он,она,они,оно,от,очень,по,под,при,с,со,так,также,такой,там,те,тем,то,того,тоже,той,только,том,ты,у,уже,хотя,чего,чей,чем,что,чтобы,чье,чья,эта,эти,это,я]
        ignore_case: true
      custom_word_delimiter:
        type: word_delimiter
        # "PowerShot" ⇒ "Power" "Shot", части одного слова становятся отдельными токенами
        generate_word_parts: true
        generate_number_parts: true  # "500-42" ⇒ "500" "42"
        catenate_words: false  # "wi-fi" ⇒ "wifi"
        catenate_numbers: false  # "500-42" ⇒ "50042"
        catenate_all: false  # "wi-fi-4000" ⇒ "wifi4000"
        split_on_case_change: true  # "PowerShot" ⇒ "Power" "Shot"
        preserve_original: false  # "500-42" ⇒ "500-42" "500" "42"
        split_on_numerics: true  # "j2se" ⇒ "j" "2" "se"
```

### logging.yml

```yaml
# you can override this using by setting a system property, for example -Des.logger.level=DEBUG
es.logger.level: INFO
rootLogger: ${es.logger.level}, console, file
logger:
  # log action execution errors for easier debugging
  action: DEBUG
  # reduce the logging for aws, too much is logged under the default INFO
  com.amazonaws: WARN

  # gateway
  #gateway: DEBUG
  #index.gateway: DEBUG

  # peer shard recovery
  #indices.recovery: DEBUG

  # discovery
  #discovery: TRACE

  index.search.slowlog: TRACE, index_search_slow_log_file
  index.indexing.slowlog: TRACE, index_indexing_slow_log_file

additivity:
  index.search.slowlog: false
  index.indexing.slowlog: false

appender:
  console:
    type: console
    layout:
      type: consolePattern
      conversionPattern: "[%d{ISO8601}][%-5p][%-25c] %m%n"

  file:
    type: dailyRollingFile
    file: ${path.logs}/${cluster.name}.log
    datePattern: "'.'yyyy-MM-dd"
    layout:
      type: pattern
      conversionPattern: "[%d{ISO8601}][%-5p][%-25c] %m%n"

  index_search_slow_log_file:
    type: dailyRollingFile
    file: ${path.logs}/${cluster.name}_index_search_slowlog.log
    datePattern: "'.'yyyy-MM-dd"
    layout:
      type: pattern
      conversionPattern: "[%d{ISO8601}][%-5p][%-25c] %m%n"

  index_indexing_slow_log_file:
    type: dailyRollingFile
    file: ${path.logs}/${cluster.name}_index_indexing_slowlog.log
    datePattern: "'.'yyyy-MM-dd"
    layout:
      type: pattern
      conversionPattern: "[%d{ISO8601}][%-5p][%-25c] %m%n"
```

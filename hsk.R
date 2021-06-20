setwd('~/prog/hsk')
h = read.csv('new_hsk.csv',sep='\t')
head(h)
h[h$pos != '','pos']
h[h$example != '','example']
h[h$alternative != '','alternative']
any(!is.na(h$multiple))

s = read.csv('sentences.tsv',sep='\t')
head(s)
class(s$HSK.average)
summary(s$HSK.average)
summary(s$Custom.Ratio)
hist(s$HSK.average)
table(floor(s$HSK.average))

install.packages('jsonlite')
install.packages('stringdist')
library(jsonlite)
library(stringdist)

n = read.csv('new_hsk.csv',sep='\t')[,3:5]
head(n)

hsk = 1
i = 266
for (hsk in 1:7) {
  if (hsk < 7) {
    j = fromJSON(paste0('json/hsk-level-',hsk,'.json'))
  } else {
    hsk = '7-9'
  }
  print(hsk)
  flush.console()
  h = read.csv(paste0('HSK-3.0/HSK ',hsk,'.tsv'),sep='\t',head=F)
  for (i in 1:nrow(h)) {
    zh = h[i,2]
    py = h[i,3]
    if (length(which(j$hanzi == zh & j$pinyin == py)) > 0 |
        length(which(n$simplified == zh & n$pinyin == py)) > 0) { # encontrou
      jtrad = gsub("'","’",unlist(j$translations[which(j$hanzi == zh & j$pinyin == py)]))
      ntrad = trimws(unlist(strsplit(n$definitions[which(n$simplified == zh & n$pinyin == py)],';')))
      htrad = trimws(unlist(strsplit(h[i,4],','))) # ,|;
      if (length(ntrad) > 0) {
        for (k in 1:length(ntrad)) {
          if (min(stringdist(ntrad[k],htrad,weight=c(.001,1,1,1))/nchar(ntrad[k])) > .5) { # não é similar o bastante, acrescenta
            htrad[length(htrad)+1] = ntrad[k]
          }
        }
      }
      if (length(jtrad) > 0) {
        for (k in 1:length(jtrad)) {
          if (min(stringdist(jtrad[k],htrad,weight=c(.001,1,1,1))/nchar(jtrad[k])) > .5) { # não é similar o bastante, acrescenta
            htrad[length(htrad)+1] = jtrad[k]
          }
        }
      }
      h[i,4] = paste0(gsub('_',' ',htrad),collapse=', ')
    } else { # não encontrou
      h[i,4] = gsub('_',' ',h[i,4])
    }
  }
  write.table(h,paste0('HSK-3.0/improved/HSK ',hsk,'.tsv'),sep='\t',quote=F,row.names=F,col.names=F)
}

# Junta todos os HSK
hh = 1
for (hsk in 1:7) {
  if (hsk == 7) {
    hsk = '7-9'
  }
  h = read.csv(paste0('HSK-3.0/HSK ',hsk,'.tsv'),sep='\t',head=F,quote='')
  h$V5 = hsk
  print(paste0(hsk,': ',nrow(h),' linhas'))
  flush.console()
  if (length(hh) < 2) {
    hh = h
  } else {
    hh = rbind(hh,h)
  }
}
head(hh)
hh2 = hh[!duplicated(hh$V1),]
head(hh2)
write.table(hh2,'HSK-nodups.tsv',sep='\t',quote=F,row.names=F,col.names=F)
#
sort(hh[duplicated(hh$V1),2])
duplicated(c(1,2,3,4,3,6))

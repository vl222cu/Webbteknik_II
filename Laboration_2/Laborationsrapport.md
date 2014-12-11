Laborationsrapport
==================

## Säkerhet

### Säkerhetshål

> Hashningen sker på användarnamnet och inte lösenordet. Detta gör att lösenordet används i klartext i databasen och kan återges.

### Hur säkerhetshålet kan utnyttjas

> Om databasen hamnar i orätta händer kommer även förövraren åt alla användaruppgifter utan större problem och kan då komma över användarnas konton.

### Vad för skada säkerhetshålet kan göra

> Identitetsstölder, bedrägerier

### Åtgärd av säkerhetshål

> Hashar lösenordet med slumpad salt för att få unik hash

* * *

### Säkerhetshål

> Applikationen är inte skyddad mot sql-injections

### Hur säkerhetshålet kan utnyttjas

> Genom att skjuta in skadlig kod som exekveras mot databasen

### Vad för skada säkerhetshålet kan göra

> En lyckad sql-injectionsattack tillåter angriparen att komma över känslig information i databasen såsom användaruppgifter, att manipulera databasens innehåll, att förstöra databasens innehåll eller att ta över databasservern helt och hållet

### Åtgärd av säkerhetshål

> Genom att parametrisera SQL-satserna 

* * *

### Säkerhetshål

> Validering mot ogiltiga tecken saknas i namnfält och textboxfält såsom HTML-taggar

### Hur säkerhetshålet kan utnyttjas

> Genom att skicka in skadlig kod via scripttagg, a-tagg etc

### Vad för skada säkerhetshålet kan göra

> Det kan orsaka oönskade effekter i webbläsaren eller användas för att stjäla information från webbläsaren genom cross site scripting

### Åtgärd av säkerhetshål

> Genom att sanitera indata och ta bort ogiltiga tecken

* * *

### Säkerhetshål

> Saknar skydd mot sessionsstölder

### Hur säkerhetshålet kan utnyttjas

> Genom att använda den stulna sessionskakan för att logga in i en annan typ av webbläsare

### Vad för skada säkerhetshålet kan göra

> Identitetsstölder, bedrägerier

### Åtgärd av säkerhetshål

> Genom att kontrollera användarens webbläsare och/eller IP-adress

* * *

### Säkerhetshål

> Autentisering saknas 

### Hur säkerhetshålet kan utnyttjas

> Oavsett om användaruppgifter finns i databasen eller inte så loggas användaren in 

### Vad för skada säkerhetshålet kan göra

> Applikationen blir tillgänglig för alla och känslig information kan läckas ut

### Åtgärd av säkerhetshål

> Genom att faställa användarens identitet i databasen

* * *

### Säkerhetshål

> Saknar skydd mot CSRF 

### Hur säkerhetshålet kan utnyttjas

> Genom att utnyttja en autentiserad användares webbplats för att utföra oönskade handlingar 

### Vad för skada säkerhetshålet kan göra

> En lyckad CSRF kan leda till att angriparen kan från användarens webbplats utan användarens kännedom göra överföringar av kapital, göra ändringar av användaruppgifter såsom lösenord, göra inköp av varor i användarens namn etc.

### Åtgärd av säkerhetshål

> Genom att använda sig av en gömd token som kontrolleras varje gång ett postutförande görs 

* * *

### Säkerhetshål

> Korrekt utloggning saknas

### Hur säkerhetshålet kan utnyttjas

> Användaren är fortfarande inloggad via sessionen 

### Vad för skada säkerhetshålet kan göra

> Känslig information kan läcka ut

### Åtgärd av säkerhetshål

> Genom att döda sessionen

* * *

## Optimering

### Laddning av resurser

> Javascript flyttas till slutet av bodytaggen så att DOMen hinner laddas innan Javascripten exekveras. Detta gör att användaren har något att titta på medan Javascripten laddas i bakgrunden och ska även förbättra laddningstiden. 

> Referenser: http://www.slideshare.net/valtechsweden/optimera-din-sidladdning-en-djupdykning-i-prestanda-p-webben, http://stackoverflow.com/questions/1638670/javascript-at-bottom-top-of-web-page, http://demianlabs.com/lab/post/top-or-bottom-of-the-page-where-should-you-load-your-javascript/

#### Observation innan åtgärd (utan webläsar-cache)

* Requests: 15 st
* Storlek: 841KB 
* Laddningstid : 758ms-1s

#### Observation efter åtgärd (utan webläsar-cache)

* Requests: 15 st
* Storlek: 574 KB
* Laddningstid : 530ms-550ms

> Som det verkar så hjälpte det att flytta javascripten till slutet av bodytaggen då laddningstiden förbättrades med en tredjedel av laddningstiden efter åtgärd.

* * *

### Ta bort onödiga resurser

> Reusurser som inte används bör tas bort då ett HTTP-anrop görs för varje resurs och varje sådant anrop tar tid och i detta fall onödig tid.

> Referenser: http://webbriktlinjer.se/r/54-optimera-webbplatsen-for-basta-prestanda/

#### Observation innan åtgärd (utan webläsar-cache)

* Requests: 15 st
* Storlek: 574 KB
* Laddningstid : 530ms-550ms

#### Observation efter åtgärd (utan webläsar-cache)

* Requests: 10 st
* Storlek: 523 KB
* Laddningstid : 490ms-520ms

> Det finns tre resurser som får status 404 Not Found, longpoll.js, b.jpg och logo.png. Tar bort longpoll.js då filen saknas helt och b.jpg då den inte används. CSS-filen dyn.css används inte heller så tar bort den också. Hittar även dubbla inkluderade script till jquery.js, tar bort den ena. Script.js har inget innehåll så tar bort den med. 

> Laddningstiden går aningen snabbare enligt mätningen efter att ha rensat bland resurserna men inget man märker av direkt.

* * *

### CDN

> Länk till resurs på en central lagringsplats bör användas istället när det gäller generella bibliotek som jQuery och Bootstrap. Detta för att minska datatrafiken på ens egen server samt större sannorlikhet att klienten redan har resursen i sin cache och inte behöver hämta den på nytt. 

> Referenser: http://webbriktlinjer.se/r/54-optimera-webbplatsen-for-basta-prestanda/

#### Observation innan åtgärd (utan webläsar-cache)

* Requests: 10 st
* Storlek: 523 KB
* Laddningstid : 490ms-520ms

#### Observation efter åtgärd (utan webläsar-cache)

* Requests: 10 st
* Storlek: 112 KB
* Laddningstid : 600ms-1s

> Byter ut resurserna mot CDN och tar bort resurserna för Bootstrap och Jquery som inte längre används. Trots att resurserna minskas och även storleken så ökar laddningstiden efter denna åtgärd. Kan bero på att appen körs lokalt för tillfället. 

* * *

### Spriting av bilder

> För att spara på HTTP-anrop och få snabbare laddningstid gäller det att välja rätt format för bilder. Sprites är ett bättre alternativ när det gäller mindre bilder som ikoner av olika slag.

> Referenser: http://www.smashingmagazine.com/2009/04/27/the-mystery-of-css-sprites-techniques-tools-and-tutorials/, http://webbriktlinjer.se/r/54-optimera-webbplatsen-for-basta-prestanda/

#### Observation innan åtgärd (utan webläsar-cache)

* Requests: 10 st
* Storlek: 112 KB
* Laddningstid : 600ms-1s

#### Observation efter åtgärd (utan webläsar-cache)

* Requests: 10 st
* Storlek: 113 KB
* Laddningstid : 500ms-800ms

> Då det är så få bilder som används är det nästan ingen skillnad på laddningstiden genom att använda sprite i detta fall.

* * *

### Long-Polling

> Min lösning för long-polling har jag placerat i getMessages-funktionen i filen MessageBoard.js i och med det är i denna funktion som meddelanden hämtas från databasen. Jag har kapslat in ajaxanropet som egen funktion som i sin tur anropas första gången när man loggar in. Därefter har jag använt funktionen setInterval som gör ett anrop till ajaxfunktionen varannan sek för att stämma av om det kommit till några nya meddelanden som en räknare håller koll på mellan klienten och servern. Genom att radera messageArea och loopa igenom JSON-arrayen uppdateras samtliga meddelanden efter den timestamp de fått i databasen när meddelandet skapades. Då jag har använt mig av ORDER BY DESC i SQL-förfrågan vid hämtning av meddelanden i databasen hamnar det sista skrivna meddelandet högst upp i meddelandelistan.

> Fördelarna med denna lösning är att jag inte behövde skriva om koden alldeles för mycket och kunde använda mig av den kod som redan finns tillgänglig vilket sparade mig tid samt att nya meddelanden pushas upp med en gång i meddelandelistan. 

> Nackdelen med denna lösning är att setInterval pågår i oändlighet så länge användaren är inloggad vilket gör att det blir en ständing upp -och nedkoppling mellan server och klient samt överföring av den stora http headern vid varje uppdatering är kostsamt ur en bandbredd och batteriförbruknings synvinkel.


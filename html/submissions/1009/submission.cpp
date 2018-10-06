#include <bits/stdc++.h>
long long i,d,n;
int main () {
    scanf("%lld", &n);
    while (n>0) {
        i=n%10;
        if (i%2!=0) d+=i;
        n=n/10;
    }
    printf("%lld", d);
}

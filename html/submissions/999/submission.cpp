#include<cstdio>

long long s=0, t=0, u=1e12;
long a[33], v=0;
int n;

long long abs(long long n)
{
    if (n>=0) return n; return -n;
}

void update(long long p)
{
    if (abs(s-2*p)<u)
    {
        u=abs(s-2*p);
        v=0;
    }
    if (abs(s-2*p)<=u) ++v;
}

void divide(int i)
{
    for (int j=0; j<=1; ++j)
    {
        t+=j*a[i];
        if (i<n) divide(i+1);
        else update(t);
        t-=j*a[i];
    }
}

int main()
{
    scanf("%d", &n);
    for (int i=1; i<=n; ++i) scanf("%ld", a+i);
    for (int i=1; i<=n; ++i) s+=a[i];
    divide(1);
    printf("%lld %ld", u, v/2);
    return 0;
}
